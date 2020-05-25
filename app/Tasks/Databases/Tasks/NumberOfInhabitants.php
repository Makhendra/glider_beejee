<?php
namespace App\Tasks\Databases\Tasks;

use App\Tasks\Databases\Services\FamilyDatabaseService;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\Databases\TableDatabaseTrait;

class NumberOfInhabitants implements TaskInterface
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
        $this->data = compact('families');
        return $this->data;
    }

    public function getAnswer() {
        $answer = 0;
        foreach ($this->data['families'] as $family) {
            if(isset($family['childrens'])) {
                $answer += count($family['childrens']) > 1 ? 1 : 0;
            }
        }
        return $answer;
    }

    public function replaceArray(): array
    {
        $answer = 0;
        $family_children_list = [];
        foreach ($this->data['families'] as $family) {
            if(isset($family['childrens'])) {
                $cnt = count($family['childrens']);
                $answer += intval($cnt > 1);
                if ($cnt) {
                    $lastName = $family['mother']['last_name'] ?? $family['father']['last_name'];
                    $family_children_list[] = $lastName . '=' . $cnt;
                }
            }
        }
        $family_children_list = implode(',<br> ', $family_children_list);
        return [
            '{family_cnt}' => count($this->data['families']),
            '{family_children_list}' => $family_children_list,
            '{answer}' => $answer,
        ];
    }

    public function setSession() {
        $userTaskId = $this->userTask->id;
        $start = $this->getStartSession($userTaskId);
        $this->setTables($userTaskId, $start);
    }
}