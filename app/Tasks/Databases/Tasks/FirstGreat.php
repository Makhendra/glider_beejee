<?php


namespace App\Tasks\Databases\Tasks;


use App\Models\CustomSession;
use App\Tasks\Databases\Services\FamilyDatabaseService;
use App\Tasks\Databases\TableDatabaseTrait;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

//У кого появился первый правнук или правнучка?
class FirstGreat implements TaskInterface
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
        $families = $this->familyService->getFamiliesWithGrandchildren();
        $this->data = compact('families');
        return $this->data;
    }

    public function getAnswer()
    {
        $table1 = CustomSession::getValue("table1_{$this->userTask->id}");
        $min = PHP_INT_MAX;
        $minId = 0;
        foreach ($this->data['families'] as $family) {
            $isGreatGrandChild = isset($family['family']['family']['family']['childrens']);
            if($isGreatGrandChild) {
                $childrens = $family['family']['family']['family']['childrens'];
                usort($childrens, function ($item1, $item2) {
                    return $item1['year'] > $item2['year'];
                });
                $children = array_shift($childrens);
                if($children['year'] < $min) {
                    $min = $children['year'];
                    $family_id = $family['mother']['family_id'] ?? $family['father']['family_id'];
                     $parentsId = array_filter(
                        $table1,
                        function ($element) use ($family_id) {
                            $family_id = $element['not_use']['family_id'] == $family_id;
                            $is_parent = $element['not_use']['is_parent'];
                            $is_child = $element['not_use']['is_child'] == false;
                            return $family_id && $is_parent && $is_child;
                        }
                    );
                    usort($parentsId, function ($item1, $item2) {
                        return $item1['id'] > $item2['id'];
                    });
                    $minId = $parentsId[0]['id'];
                }
            }
        }
        return $minId;
    }

    public function replaceArray(): array
    {
        return [
            '{answer}' => $this->getAnswer()
        ];
    }

    public function setSession() {
        $userTaskId = $this->userTask->id;
        $start = $this->getStartSession($userTaskId);
        $this->setTablesWithRecourse($userTaskId, $start);
    }
}