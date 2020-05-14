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

    public function validateRules()
    {
        // TODO: Implement validateRules() method.
    }

    public function checkAnswer(Request $request)
    {
        // TODO: Implement checkAnswer() method.
    }
}