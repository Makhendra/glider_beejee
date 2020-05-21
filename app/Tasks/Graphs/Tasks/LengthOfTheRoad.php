<?php


namespace App\Tasks\Graphs\Tasks;


use App\Tasks\Graphs\Services\GraphImageService;
use App\Tasks\Graphs\Services\GraphService;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

// Какова протяженность дороги от пункта А до пункта Б?
class LengthOfTheRoad implements TaskInterface
{
    use TaskTrait;
    public $classLayout = 'col-md-6';
    public $classLayout2 = 'col-md-6';

    public function getView()
    {
        return 'tasks.show_templates.GD_Task';
    }

    public function initData()
    {
        $alpha = getAlpha();
        $graph = (new GraphService())->generateGraph();
        $alpha = array_slice($alpha, 0, count($graph));
        $image = (new GraphImageService())->getImage($graph);

        $cnt = count($graph) - 1;
        $start = random_int(0, $cnt);
        $end = random_int(0, $cnt);
        while ($start == $end) {
            $start = random_int(0, $cnt);
            $end = random_int(0, $cnt);
        }
        $start = ['num' => $start, 'alpha' => $alpha[$start]];
        $end = ['num' => $end, 'alpha' => $alpha[$end]];
        $answer = $graph[$start['num']][$end['num']];

        $this->data = compact('graph', 'image', 'start', 'end', 'answer');
        return $this->data;
    }

    public function replaceArray(): array
    {
        return [
            '{graph}' => $this->data['image'],
            '{start}' => $this->data['start']['alpha'],
            '{end}' => $this->data['end']['alpha'],
        ];
    }

    public function getAnswer() {
        return $this->data['answer'];
    }

}