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
                return new Tasks\InequalityHolds($this->task);
            case 2:
                return new Tasks\NumberInTheList($this->task);
            case 5:
                return new Tasks\Computation($this->task);
            case 6:
                return new Tasks\NumbersFormTheRange($this->task);
            case 7:
                return new Tasks\MinOrMax($this->task);
            case 8:
                return new Tasks\OneOfZero($this->task);
            case 9:
                return new Tasks\CountMaxOrMin($this->task);
            case 10:
                return new Tasks\ConvertNumber($this->task);
            case 11:
                return new Tasks\ZerosInBinary($this->task);
            default:
                return new DefaultTask($this->task);
        }
    }
}