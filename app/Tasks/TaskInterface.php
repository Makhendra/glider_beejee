<?php


namespace App\Tasks;


use Illuminate\Http\Request;

interface TaskInterface
{
    public function initData();

    public function checkAnswer(Request $request) : array;

    public function getData();
    public function getAnswer();
    public function getView();

    public function setData($data);
    public function setUserTask($userTask);
    public function setTextUserTask($textUserTask);
    public function setFormatAnswer();
    public function setSuccess($data);

    public function replaceArray() : array;
    public function replaceText();
    public function replaceTextAnswer();
}
