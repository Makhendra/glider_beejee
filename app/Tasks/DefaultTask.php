<?php


namespace App\Tasks;


class DefaultTask implements TaskInterface
{
    public $task;
    public $userTask;
    public $error;

    public function __construct($task)
    {
        $this->task = $task;
        $this->error = true;
    }

    public function answer()
    {
        // TODO: Implement answer() method.
    }

    public function setUserTask($userTask)
    {
        $this->userTask = $userTask->data;
        $this->replaceText();
    }

    public function getData()
    {
        return get_object_vars($this);
    }

    public function initData()
    {
        // TODO: Implement initData() method.
    }

    public function getView()
    {
        return 'tasks.show_templates._default';
    }

    public function replaceText()
    {
        // TODO: Implement replaceText() method.
    }
}