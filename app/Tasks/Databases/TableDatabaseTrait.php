<?php


namespace App\Tasks\Databases;


use App\Models\CustomSession;
use App\Models\Family;
use App\Tasks\Databases\Services\FamilyDatabaseService;

trait TableDatabaseTrait
{

    public function getStartSession($userTaskId)
    {
        $start = CustomSession::getValue("start_$userTaskId");
        if (empty($start)) {
            $start = rand(1, 500);
            CustomSession::setValue("start_$userTaskId", $start);
        }
        return $start;
    }

    public function setTables($userTaskId, $start)
    {
        $table1 = CustomSession::getValue("table1_$userTaskId");
        $table2 = CustomSession::getValue("table2_$userTaskId");
        if (empty($table1) or empty($table2)) {
            $table1 = [];
            $table2 = [];
            if (isset($this->data['families'])) {
                $mothers = array_column($this->data['families'], 'mother');
                $fathers = array_column($this->data['families'], 'father');
                $childrensList = array_column($this->data['families'], 'childrens');
                $childrens = [];
                foreach ($childrensList as $child) {
                    foreach ($child as $c) {
                        $childrens[] = $c;
                    }
                }
                $table = array_merge($mothers, $fathers, $childrens);
                shuffle($table);
                foreach ($table as $key => $people) {
                    $table1[] = [
                        'id' => $start,
                        'Фамилия_И.О.' => $this->familyService->fullName($people),
                        'Пол' => $people['gender'] == Family::WOMEN_GENDER ? 'Ж' : 'М',
                        'Год_рождения' => $people['year'],
                        'not_use' => $people
                    ];
                    if (!$people['is_parent']) {
                        $table2[] = [
                            'ID_Родителя' => 'Ж',
                            'ID_Ребёнка' => $start,
                            'not_use' => $people
                        ];
                        $table2[] = [
                            'ID_Родителя' => 'М',
                            'ID_Ребёнка' => $start,
                            'not_use' => $people,
                        ];
                    }
                    $start += 1;
                }
                foreach ($table2 as $key => &$item) {
                    if (in_array($item['ID_Родителя'], ['М', 'Ж'])) {
                        $parentL = array_filter(
                            $table1,
                            function ($element) use ($item) {
                                $family_id = $element['not_use']['family_id'] == $item['not_use']['family_id'];
                                $gender = $element['not_use']['gender'] == ($item['ID_Родителя'] == 'Ж' ? Family::WOMEN_GENDER : Family::MEN_GENDER);
                                $is_parent = $element['not_use']['is_parent'];
                                return $family_id && $gender && $is_parent;
                            }
                        );
                        $parent = array_shift($parentL);
                        if (isset($parent['id'])) {
                            $item['ID_Родителя'] = $parent['id'];
                        } else {
                            unset($table2[$key]);
                        }
                    }
                }
                shuffle($table2);
            }
            CustomSession::setValue("table1_$userTaskId", $table1);
            CustomSession::setValue("table2_$userTaskId", $table2);
        }
    }

    public function setMotherList($userTaskId)
    {
        $motherList = CustomSession::getValue('motherList_' . $userTaskId);
        if (empty($motherList)) {
            $motherList = [];
            $table1 = CustomSession::getValue("table1_{$this->userTask->id}");
            $table2 = CustomSession::getValue("table2_{$this->userTask->id}");
            sort($table2);
            foreach ($table2 as $key => $value) {
                $j = $key + 1;
                $mother = array_filter(
                    $table1,
                    function ($item) use ($value) {
                        return $item['id'] == $value["ID_Родителя"] && $item['not_use']['gender'] == Family::WOMEN_GENDER;
                    }
                );
                if ($mother) {
                    $mother = array_shift($mother);
                    $children = array_filter(
                        $table1,
                        function ($item) use ($value) {
                            return $item['id'] == $value["ID_Ребёнка"];
                        }
                    );
                    $children = array_shift($children);
                    $motherList[$j] = [
                        'ID и Год Рождения матери' => $mother['id'] . ' – ' . $mother['Год_рождения'],
                        'ID_Ребёнка и Год Рождения' => $children['id'] . ' – ' . $children['Год_рождения'],
                        $this->data['age'] . ' лет' => ($children['Год_рождения'] - $mother['Год_рождения']) > $this->data['age'] ? 'Да' : 'Нет'
                    ];
                }
            }
            sort($motherList);
            CustomSession::setValue('motherList_' . $userTaskId, $motherList);
        }
    }

    public function setSonList($userTaskId, $families)
    {
        $sonList = CustomSession::getValue("sonList_$userTaskId");
        if (empty($sonList)) {
            $dataService = new FamilyDatabaseService();
            $sonList = [];
            $table1 = CustomSession::getValue("table1_{$this->userTask->id}");
            foreach ($families as $key => $family) {
                $mother = $family['mother'] ?? [];
                $ids = [];
                if ($mother) {
                    $motherId = array_filter(
                        $table1,
                        function ($item) use ($mother, $dataService) {
                            return $item['Фамилия_И.О.'] == $dataService->fullName($mother);
                        }
                    );
                    $ids[] = array_shift($motherId)['id'];
                }
                $father = $family['father'] ?? [];
                if ($father) {
                    $fatherId = array_filter(
                        $table1,
                        function ($item) use ($father, $dataService) {
                            return $item['Фамилия_И.О.'] == $dataService->fullName($father);
                        }
                    );
                    $ids[] = array_shift($fatherId)['id'];
                }
                $childrens = [];
                if (isset($family['childrens']) ? count($family['childrens']) > 1 : false) {
                    foreach ($family['childrens'] as $child) {
                        $childId = array_filter(
                            $table1,
                            function ($item) use ($child, $dataService) {
                                return $item['Фамилия_И.О.'] == $dataService->fullName($child);
                            }
                        );
                        $childId = array_shift($childId);
                        $childrens[] = $childId['id'] . ' ' . $childId['Пол'] . ' ' . $childId['Год_рождения'];
                    }
                    $sonList[] = [
                        'ID_Родителей' => implode(' – ', $ids),
                        'ID_детей' => implode('<br>', $childrens),
                    ];
                }
            }
            sort($sonList);
            CustomSession::setValue('sonList_' . $userTaskId, $sonList);
        }
    }

}