<?php


namespace App\Tasks\Databases\Tasks;


use App\Tasks\Databases\Services\FamilyDatabaseService;
use App\Tasks\Databases\TableDatabaseTrait;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

//У кого появился первый правнук или правнучка?
class FirstGreat implements TaskInterface
{
    use TaskTrait, TableDatabaseTrait;

    public $classLayout = 'col-md-8';
    public $classLayout2 = 'col-md-4';

    public function initData()
    {
        $families = (new FamilyDatabaseService())->getFamilies(5, 2, true);
        $this->data = compact('families');
        return $this->data;
    }

    public function getAnswer()
    {
        return 0;
    }

    public function replaceArray(): array
    {
        return [];
    }
}