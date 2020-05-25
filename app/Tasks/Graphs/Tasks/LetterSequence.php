<?php


namespace App\Tasks\Graphs\Tasks;


use App\Models\CustomSession;
use App\Tasks\Graphs\Services\GraphImageService;
use App\Tasks\Graphs\Services\GraphService;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

// Выпишите последовательно без пробелов и знаков препинания указанные на графе буквенные обозначения пунктов от П1 до П7?
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

    public function replaceArray(): array
    {
        return [];
    }

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