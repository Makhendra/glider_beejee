<?php


namespace App\Tasks;


use App\Models\Task;
use App\Tasks\Graphs\GD_Task;
use App\Tasks\NumberSystems\CE_Task;
use App\Tasks\NumberSystems\FW_Task;

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
        switch ($this->task->type) {
            case 1:
                return new CE_Task($this->task);
            case 2:
                return new FW_Task($this->task);
            case 3:
                return new GD_Task($this->task);
            default:
                return new DefaultTask($this->task);
        }
    }
}