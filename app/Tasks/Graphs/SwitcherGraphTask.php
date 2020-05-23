<?php
namespace App\Tasks\Graphs;

use App\Tasks\DefaultTask;

class SwitcherGraphTask
{
    private $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function getTask()
    {
        switch ($this->task->type) {
            case 3:
                return new Tasks\LengthOfTheRoad($this->task);
            case 12:
                return new Tasks\LetterSequence($this->task);
            default:
                return new DefaultTask($this->task);
        }
    }
}