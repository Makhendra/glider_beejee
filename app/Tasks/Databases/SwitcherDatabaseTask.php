<?php

namespace App\Tasks\Databases;

use App\Tasks\DefaultTask;

class SwitcherDatabaseTask
{
    private $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function getTask()
    {
        switch ($this->task->type) {
            case 4:
                return new Tasks\NumberOfInhabitants($this->task);
            case 13:
                return new Tasks\NumberOfWomen($this->task);
            case 14:
                return new Tasks\OneOlderBrother($this->task);
            default:
                return new DefaultTask($this->task);
        }
    }
}