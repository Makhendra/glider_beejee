<?php

namespace App\Tasks;


use App\Models\UserTask;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait TaskTrait
{
    public $task;
    public $userTask;
    public $textUserTask;
    public $formatAnswer;
    public $error;
    public $success;
    public $data;

    public function getView()
    {
        return 'tasks.show_templates._default';
    }

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
    }

    public function setTextUserTask($text)
    {
        $this->textUserTask = $text;
        $this->replaceText();
    }

    public function setSuccess($data){
        list($success, $user_answer) = $data;
        $status = $success? UserTask::SUCCESS : UserTask::WRONG;
        $this->userTask->update(compact('status', 'user_answer'));
    }

    public function setFormatAnswer() {
        $this->formatAnswer = $this->task->answer;
        $this->replaceTextAnswer();
    }

    public function replaceTextAnswer()
    {
        $replace = $this->replaceArray();
        $this->addReplaceCommon($replace);
        foreach ($replace as $key => $value) {
            try {
                $this->formatAnswer = str_replace($key, $value, $this->formatAnswer);
            } catch (Exception $exception) {
                Log::debug('TASK_ID '.$this->task->id.' - replaceTextAnswer');
                Log::debug($exception->getMessage());
            }
        }
    }

    public function addReplaceCommon(&$replace){
        $replace['{sup}'] = '<sup>';
        $replace['{sup_end}'] = '</sup>';
        $replace['{sub}'] = '<sub>';
        $replace['{sub_end}'] = '</sub>';
    }

    public function replaceArray() : array {
        return [];
    }

    public function replaceText()
    {
        $replace = $this->replaceArray();
        $this->addReplaceCommon($replace);
        foreach ($replace as $key => $value) {
            try {
                $this->textUserTask = str_replace($key, $value, $this->textUserTask);
            } catch (Exception $exception) {
                Log::debug('TASK_ID '.$this->task->id.' - replaceText');
                Log::debug($exception->getMessage());
            }
        }
    }

    public function replaceHowTo()
    {
        $replace = $this->replaceArray();
        $this->addReplaceCommon($replace);
        foreach ($replace as $key => $value) {
            try {
                $this->textUserTask = str_replace($key, $value, $this->textUserTask);
            } catch (Exception $exception) {
                Log::debug('TASK_ID '.$this->task->id.' - replaceText');
                Log::debug($exception->getMessage());
            }
        }
    }

    public function validateRules()
    {
        return [
            'answer' => 'required'
        ];
    }

    public function checkAnswer(Request $request): array
    {
        $request->validate($this->validateRules());
        $userAnswer = $request->get('answer');
        $answer = $this->getAnswer();
        $this->success = $userAnswer == $answer;
        return [$this->success, $userAnswer];
    }

    public function setSession() {

    }
}