<?php


namespace App\Tasks;


use Illuminate\Http\Request;

interface TaskInterface
{

    public function validateRules();

    public function getData();

    public function setData($data);

    public function initData();

    public function setUserTask($userTask);

    public function getView();

    public function replaceText();

    public function checkAnswer(Request $request);
}
