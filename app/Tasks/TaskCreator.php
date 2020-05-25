<?php


namespace App\Tasks;


use App\Models\Task;
use App\Tasks\Databases\SwitcherDatabaseTask;
use App\Tasks\NumberSystems\SwitcherNumberTask;
use App\Tasks\Graphs\SwitcherGraphTask;

class TaskCreator extends TaskFabric
{
    private $task;

    /**
     * TaskCreator constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getTask(): TaskInterface
    {
        switch ($this->task->group_id) {
            case 1:
                return (new SwitcherNumberTask($this->task))->getTask();
            case 2:
                return (new SwitcherGraphTask($this->task))->getTask();
            case 4:
                return (new SwitcherDatabaseTask($this->task))->getTask();
            default:
                return new DefaultTask($this->task);
        }
    }

}