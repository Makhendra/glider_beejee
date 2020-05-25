<?php


namespace App\Tasks\Databases\Tasks;


use App\Tasks\Databases\Services\FamilyDatabaseService;
use App\Tasks\Databases\TableDatabaseTrait;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use Throwable;

// Определите количество женщин, рожавших ребёнка после достижения n полных лет?
class NumberOfWomen implements TaskInterface
{
    use TaskTrait, TableDatabaseTrait;
    public $classLayout = 'col-md-8';
    public $classLayout2 = 'col-md-4';
    public $familyService;

    public function __construct($task)
    {
        $this->task = $task;
        $this->familyService = new FamilyDatabaseService();
    }

    public function getView()
    {
        return 'tasks.show_templates.number_of_Inhabitants';
    }

    public function initData()
    {
        $families = $this->familyService->getFamilies();
        $age = rand(25, 50);
        $this->data = compact('families', 'age');
        return $this->data;
    }

    public function replaceArray(): array
    {
        $answer = 0;
        $mothers = [];
        $exception = [];

        foreach ($this->data['families'] as $family) {
            if (isset($family['childrens']) && isset($family['mother'])) {
                foreach ($family['childrens'] as $children) {
                    if ($children['year'] - $family['mother']['year'] > $this->data['age']) {
                        $motherFamilyId = $family['mother']['family_id'];
                        if (in_array($motherFamilyId, $mothers)) {
                            if (isset($exception[$motherFamilyId])) {
                                $exception[$motherFamilyId]['cnt'] += 1;
                            } else {
                                $exception[$motherFamilyId]['cnt'] = 2;
                                $exception[$motherFamilyId]['mother'] = $this->familyService->fullName(
                                    $family['mother']
                                );
                            }
                        } else {
                            $mothers[] = $family['mother']['family_id'];
                            $answer += 1;
                        }
                    }
                }
            }
        }
        $textException = '';
        if ($exception) {
            if (count($exception) > 1) {
                $textException = 'но есть матери которые рожали больше одного раза: ';
            } else {
                $textException = 'но есть одна мама которая родила больше одного раза: ';
            }
            $cnt = 0;
            foreach ($exception as $e) {
                $textException .= $exception['mother'] . ' – ' . $e['cnt'] . '; ';
                $cnt += $e['cnt'] - 1;
            }
            $textException .= 'Поэтому нужно вычесть '.$cnt;
        }
        $html = view('components.table_database', ['table' => session('motherList_'.$this->userTask->id)]);
        try {
            $html = $html->render();
        } catch (Throwable $e) {
            $html = '';
        }
        return [
            '{answer}' => $answer,
            '{age}' => $this->data['age'],
            '{n}' => count($mothers),
            '{exception}' => $textException,
            '{mother_list}' => $html,
        ];
    }

    public function getAnswer()
    {
        $answer = 0;
        $mothers = [];
        foreach ($this->data['families'] as $family) {
            if (isset($family['childrens']) && isset($family['mother'])) {
                foreach ($family['childrens'] as $children) {
                    if ($children['year'] - $family['mother']['year'] > $this->data['age']) {
                        if (!in_array($family['mother']['family_id'], $mothers)) {
                            $mothers[] = $family['mother']['family_id'];
                            $answer += 1;
                        }
                    }
                }
            }
        }
        return $answer;
    }

    public function setSession()
    {
        $userTaskId = $this->userTask->id;
        $start = $this->getStartSession($userTaskId);
        $this->setTables($userTaskId, $start);
        $this->setMotherList($userTaskId);
    }
}