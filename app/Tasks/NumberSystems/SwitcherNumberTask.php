<?php

namespace App\Tasks\NumberSystems;

use App\Tasks\DefaultTask;

class SwitcherNumberTask
{
    private $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function getTask() {
        switch ($this->task->type) {
            case 1:
                return new InequalityHolds($this->task);
            case 2:
                return new NumberInTheList($this->task);
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
            case 10:
                return new ConvertNumber($this->task);
            default:
                return new DefaultTask($this->task);
        }
    }
}