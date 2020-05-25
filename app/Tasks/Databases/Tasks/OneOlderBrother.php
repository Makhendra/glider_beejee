<?php


namespace App\Tasks\Databases\Tasks;


use App\Models\CustomSession;
use App\Tasks\Databases\Services\FamilyDatabaseService;
use App\Tasks\Databases\TableDatabaseTrait;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use Throwable;

// Определите количество жителей, имеющих как минимум одного старшего брата?
class OneOlderBrother implements TaskInterface
{
    use TaskTrait, TableDatabaseTrait;

    public $classLayout = 'col-md-8';
    public $classLayout2 = 'col-md-4';
    public $familyService;

    public function __construct($task)
    {
        $this->task = $task;
        $this->familyService = new FamilyDatabaseService();
    }

    public function getView()
    {
        return 'tasks.show_templates.number_of_Inhabitants';
    }

    public function initData()
    {
        $families = $this->familyService->getFamilies();
        //старшего брата или дочь
        $gender = rand(0,1);
        $text = $gender == 0 ? 'одного старшего брата' : 'одну старшую дочь';
        $son_or_daughter = compact('gender', 'text');
        $this->data = compact('families','son_or_daughter');
        return $this->data;
    }

    public function replaceArray(): array
    {
        $n = CustomSession::getValue('sonList_'.$this->userTask->id) ?: [];
        $table = CustomSession::getValue('sonList_'.$this->userTask->id);
        try {
            $html = view('components.table_database', ['table' => $table])->render();
        } catch (Throwable $e) {
            $html = '';
        }
        return [
            '{one_son_or_daughter}' => $this->data['son_or_daughter']['text'],
            '{son_or_daughter}' => $this->data['son_or_daughter']['text'],
            '{answer}' => $this->getAnswer(),
            '{son_list}' => $html,
            '{n}' => count($n)
        ];
    }

    public function getAnswer()
    {
        $answer = 0;
        $gender = $this->data['son_or_daughter']['gender'];
        foreach ($this->data['families'] as $family) {
            if (isset($family['childrens'])) {
               if(count($family['childrens']) >= 2) {
                   $childrens = $family['childrens'];
                   $old = false;
                   usort($childrens, function ($item1, $item2) {
                        return $item1['year'] < $item2['year'];
                   });
                   foreach ($childrens as $key => $children) {
                       if($key == 0) {
                           continue;
                       }
                       if(!$old && $gender == $children['gender']) {
                           $old = true;
                           $answer += 1;
                       }
                   }
               }
            }
        }
        return $answer;
    }

    public function setSession()
    {
        $userTaskId = $this->userTask->id;
        $start = $this->getStartSession($userTaskId);
        $this->setTables($userTaskId, $start);
        $this->setSonList($userTaskId, $this->data['families']);
    }
}