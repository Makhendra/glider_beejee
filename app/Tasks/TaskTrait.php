<?php

namespace App\Tasks;


trait TaskTrait
{
    public $task;
    public $userTask;
    public $error;
    public $data;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function getData()
    {
        return get_object_vars($this);
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setUserTask($userTask)
    {
        $this->userTask = $userTask;
        $this->replaceText();
    }
}