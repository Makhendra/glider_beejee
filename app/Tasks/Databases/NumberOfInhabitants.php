<?php
namespace App\Tasks\Databases;

use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use Illuminate\Http\Request;

class NumberOfInhabitants implements TaskInterface
{
    use TaskTrait;

    public $classLayout = 'col-md-8';
    public $classLayout2 = 'col-md-4';

    public function getView()
    {
        return 'tasks.show_templates.number_of_Inhabitants';
    }

    public function initData()
    {
        $families = (new FamilyDatabaseService())->getFamilies();
        $this->data = compact('families');
        return $this->data;
    }


    public function validateRules()
    {
        return [
            'answer' => 'required'
        ];
    }

    public function replaceText(){}

    public function checkAnswer(Request $request)
    {
        $request->validate($this->validateRules());
        $data = $request->all();
        $answer = 0;
        foreach ($this->data['families'] as $family) {
            $answer += count($family['childrens']) ? 1 : 0;
        }
        if ($data['answer'] == $answer) {
            return success();
        } else {
            return fail();
        }
    }
}