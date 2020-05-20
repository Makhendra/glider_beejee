<?php


namespace App\Tasks;


use App\Models\Task;
use App\Tasks\Databases\NumberOfInhabitants;
use App\Tasks\Graphs\GD_Task;
use App\Tasks\NumberSystems\SwitcherNumberTask;

class TaskCreator extends TaskFabric
{
    private $task;
    private $userTask;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function setUserTask($userTask) {
        $this->userTask = $userTask;
    }

    public function getTask(): TaskInterface
    {
        switch ($this->task->group_id) {
            case 1:
                return (new SwitcherNumberTask($this->task))->getTask();
            case 2:
                return $this->getGraphSwitcher();
            case 3:
                return $this->getDatabaseSwitcher();
            default:
                return new DefaultTask($this->task);
        }
    }

    public function getDatabaseSwitcher() {
        switch ($this->task->type) {
            case 4:
                return new NumberOfInhabitants($this->task);
            default:
                return new DefaultTask($this->task);
        }
    }

    public function getGraphSwitcher() {
        switch ($this->task->type) {
            case 3:
                return new GD_Task($this->task);
            default:
                return new DefaultTask($this->task);
        }
    }
}