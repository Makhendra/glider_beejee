<?php


namespace App\Tasks\Graphs\Tasks;


use App\Models\CustomSession;
use App\Tasks\Graphs\Services\GraphImageService;
use App\Tasks\Graphs\Services\GraphService;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

// Какова протяженность дороги от пункта А до пункта Б?
class LengthOfTheRoad implements TaskInterface
{
    private $graphService;
    private $graphImageService;

    public function __construct($task)
    {
        $this->task = $task;
        $this->graphService = new GraphService();
        $this->graphImageService = new GraphImageService();
    }

    use TaskTrait;
    public $classLayout = 'col-md-6';
    public $classLayout2 = 'col-md-6';

    public function getView()
    {
        return 'tasks.show_templates.length_road';
    }

    public function initData()
    {
        $alpha = getAlpha();
        $this->graphService->generateGraph();
        $alpha = array_slice($alpha, 0, count($this->graphService->matrix));

        $cnt = count($this->graphService->matrix) - 1;
        $start = rand(0, $cnt);
        $end = rand(0, $cnt);
        while ($start == $end) {
            $start = rand(0, $cnt);
            $end = rand(0, $cnt);
        }
        $start = ['num' => $start, 'alpha' => $alpha[$start]];
        $end = ['num' => $end, 'alpha' => $alpha[$end]];
        $this->graphService->checkPath($start['alpha'], $end['alpha']);
        $graph = $this->graphService->matrix;

        $random_keys = [];
        array_walk(
            $graph,
            function ($item, $key) use (&$random_keys) {
                array_push($random_keys, $key);
            }
        );
        shuffle($random_keys);
        $this->data = compact('graph', 'start', 'end', 'random_keys');
        return $this->data;
    }

    public function replaceArray(): array
    {
        $this->graphService->setMatrix($this->data['graph']);
        return [
            '{graph}' => $this->data['graph'],
            '{start}' => $this->data['start']['alpha'],
            '{end}' => $this->data['end']['alpha'],
            '{path}' => $this->graphService->getFormatPaths($this->data['start']['alpha'], $this->data['end']['alpha']),
            '{points}' => $this->graphService->getPoints($this->data['random_keys']),
            '{answer}' => $this->getAnswer(),
        ];
    }

    public function getAnswer()
    {
        $distance = $this->graphService->getDistance($this->data['start']['alpha'], $this->data['end']['alpha']);
        $distance = $distance == INF ? 0 : $distance;
        return $distance;
    }

    public function setSession()
    {
        $image = CustomSession::getValue("image_{$this->userTask->id}");
        if(empty($image)) {
            $image = $this->graphImageService->getImage($this->data['graph']);
            CustomSession::setValue("image_{$this->userTask->id}", $image);
        }
    }

}