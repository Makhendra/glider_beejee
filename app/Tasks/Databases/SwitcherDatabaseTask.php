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
            case 13:
                return new Tasks\NumberOfWomen($this->task);
            case 14:
                return new Tasks\OneOlderBrother($this->task);
            case 15:
                return new Tasks\HowManyChildren($this->task);
            case 16:
                return new Tasks\FirstGreat($this->task);
            default:
                return new DefaultTask($this->task);
        }
    }
}