<?php


namespace App\Tasks\Databases\Tasks;


use App\Models\CustomSession;
use App\Tasks\Databases\Services\FamilyDatabaseService;
use App\Tasks\Databases\TableDatabaseTrait;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

// Ниже представлены фрагменты двух таблиц из базы данных о жителях некоторого поселка.
// Каждая строка таблицы 2 содержит информацию о ребёнке и об одном из его родителей.
// На основании приведённых данных определите количество женщин,
// имеющих не менее {n_children} в возрасте до {age} лет (включительно) по состоянию на {year} год.
// При вычислении ответа учитывайте только информацию из приведённых фрагментов таблиц.
class HowManyChildren implements TaskInterface
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

        $n = rand(1, 2);
        $age = rand(7, 18);

        $yearsMother = array_column(array_column($families, 'mother'), 'year');
        $yearsFather = array_column(array_column($families, 'father'), 'year');
        $years = array_merge($yearsMother, $yearsFather);
        $year = round(array_sum($years) / count($years), 0) + 20 + $age;

        $this->data = compact('n', 'age', 'year', 'families');
        return $this->data;
    }

    //Для этой задачи нужно соотнести таблицы, выписать мам и их детей. Потом вычеркнуть тех кто не подходит под условие и посчитать.
    public function getAnswer()
    {
        $answer = 0;
        foreach ($this->data['families'] as $family) {
            $childrens = $family['childrens'] ?? [];
            foreach ($childrens as $children) {
                $diff = $this->data['year'] - $children['year'];
                if( $diff <= $this->data['age'] && $diff > 0 ) {
                    $answer += 1;
                }
            }
        }
        return $answer;
    }

    //Выпишем детей:
    //{children_list}
    //Ответ: {answer}
    public function replaceArray(): array
    {
        $table = CustomSession::getValue('childrenList_'.$this->userTask->id) ?: [];
        try {
            $html = view('components.table_database', ['table' => $table])->render();
        } catch (Throwable $e) {
            $html = '';
        }
        return [
            '{n_children}' => $this->data['n'].' '.trans_choice('ребёнка|детей|детей', $this->data['n']),
            '{age}' => $this->data['age'],
            '{year}' => $this->data['year'],
            '{answer}' => $this->getAnswer(),
            '{children_list}' => $html,
        ];
    }

    public function setSession() {
        $userTaskId = $this->userTask->id;
        $start = $this->getStartSession($userTaskId);
        $this->setTables($userTaskId, $start);
        $this->setChildrenList($userTaskId, $this->data['year']);
    }
}