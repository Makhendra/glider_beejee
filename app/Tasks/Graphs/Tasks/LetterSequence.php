<?php


namespace App\Tasks\Graphs\Tasks;


use App\Models\CustomSession;
use App\Tasks\Graphs\Services\GraphImageService;
use App\Tasks\Graphs\Services\GraphService;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

// На рисунке схема дорог изображена в виде графа, в таблице содержатся сведения о длине этих дорог в километрах. 
//Так как таблицу и схему рисовали независимо друг от друга, нумерация населённых пунктов
// в таблице никак не связана с буквенными обозначениями на графе.
//
//Выпишите последовательно без пробелов и знаков препинания указанные на графе буквенные обозначения пунктов от П1 до П7:
// сначала букву, соответствующую П1, затем букву, соответствующую П2, и т. д.
class LetterSequence implements TaskInterface
{
    use TaskTrait;

    private $graphService;
    private $graphImageService;

    public $classLayout = 'col-md-6';
    public $classLayout2 = 'col-md-6';

    public function __construct($task)
    {
        $this->task = $task;
        $this->graphService = new GraphService();
        $this->graphImageService = new GraphImageService();
    }

    public function getView()
    {
        return 'tasks.show_templates.letter_sequence';
    }

    public function initData()
    {
        $graph = $this->graphService->generateGraph(5);

        $random_keys = [];
        array_walk(
            $graph,
            function ($item, $key) use (&$random_keys) {
                array_push($random_keys, $key);
            }
        );
        shuffle($random_keys);

        $this->data = compact('graph', 'random_keys');
        return $this->data;
    }

    //Соотнесем точки:
    //
    //{points}
    //
    //Выпишем последовательность {answer}
    public function replaceArray(): array
    {
        return [
            '{answer}' => $this->getAnswer(),
            '{points}' => $this->graphService->getPoints($this->data['random_keys']),
        ];
    }

    //Нужно соотнести таблицу и рисунок. Проще всего это делать от точек, которые сильно отличаются от других.
    //
    //К примеру к населенному пункту не ведет ни одна дорога и такой пункт в единственном числе. 
    //
    //Или точка имеет соединение со всеми остальными, а других меньше.
    public function getAnswer()
    {
        return implode('', $this->data['random_keys']);
    }

    public function setSession()
    {
        $image = CustomSession::getValue("image_{$this->userTask->id}");
        if(empty($image)) {
            $image = $this->graphImageService->getImage($this->data['graph'], true);
            CustomSession::setValue("image_{$this->userTask->id}", $image);
        }
    }
}