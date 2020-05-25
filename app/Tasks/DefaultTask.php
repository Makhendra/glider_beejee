<?php


namespace App\Tasks;


use Illuminate\Http\Request;

class DefaultTask implements TaskInterface
{
    use TaskTrait;

    public $task;
    public $userTask;
    public $error;

    public function __construct($task)
    {
        $this->task = $task;
        $this->error = true;
    }

    public function initData()
    {
        return $this->data;
    }

    public function getView()
    {
        return 'tasks.show_templates._default';
    }

    public function replaceText()
    {
        return [];
    }

    public function validateRules()
    {
        return [];
    }

    public function checkAnswer(Request $request) : array
    {
        return [];
    }

    public function replaceArray(): array
    {
       return [];
    }

    public function getAnswer() {
        return 0;
    }
}