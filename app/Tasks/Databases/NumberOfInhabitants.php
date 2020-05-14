<?php
namespace App\Tasks\Databases;

use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use Illuminate\Http\Request;

class NumberOfInhabitants implements TaskInterface
{
    use TaskTrait;

    public $classLayout = 'col-md-7';
    public $classLayout2 = 'col-md-5';

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
        // TODO: Implement validateRules() method.
    }

    public function replaceText()
    {
        // TODO: Implement replaceText() method.
    }

    public function checkAnswer(Request $request)
    {
        // TODO: Implement checkAnswer() method.
    }
}