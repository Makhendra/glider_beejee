<?php


namespace App\Tasks;


use App\Models\Task;
use App\Tasks\Databases\NumberOfInhabitants;
use App\Tasks\Graphs\GD_Task;
use App\Tasks\NumberSystems\CE_Task;
use App\Tasks\NumberSystems\CountMaxOrMin;
use App\Tasks\NumberSystems\FW_Task;
use App\Tasks\NumberSystems\ComputationTask;
use App\Tasks\NumberSystems\MinOrMaxTask;
use App\Tasks\NumberSystems\NumbersFormTheRange;
use App\Tasks\NumberSystems\OneOfZeroTask;

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
                return $this->getNumberSwitcher();
            case 2:
                return $this->getGraphSwitcher();
            case 3:
                return $this->getDatabaseSwitcher();
            default:
                return new DefaultTask($this->task);
        }
    }

    public function getNumberSwitcher() {
        switch ($this->task->type) {
            case 1:
                return new CE_Task($this->task);
            case 2:
                return new FW_Task($this->task);
            case 5:
                return new ComputationTask($this->task);
            case 6:
                return new NumbersFormTheRange($this->task);
            case 7:
                return new MinOrMaxTask($this->task);
            case 8:
                return new OneOfZeroTask($this->task);
            case 9:
                return new CountMaxOrMin($this->task);
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