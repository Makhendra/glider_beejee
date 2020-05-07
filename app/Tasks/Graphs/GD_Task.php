<?php


namespace App\Tasks\Graphs;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use Illuminate\Http\Request;

class GD_Task implements TaskInterface
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
        shuffle($alpha);
        $graph = (new GraphService())->generateGraph();
        $alpha = array_slice($alpha, 0, count($graph));
        $image = (new GraphImageService())->getImage($graph, $alpha);

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

    public function validateRules()
    {
        return [];
    }


    public function checkAnswer(Request $request)
    {
        // TODO: Implement checkAnswer() method.
    }

    public function replaceText()
    {
        $this->userTask = str_replace('{graph}', $this->data['image'], $this->userTask);
        $this->userTask = str_replace('{start}', $this->data['start']['alpha'], $this->userTask);
        $this->userTask = str_replace('{end}',   $this->data['end']['alpha'], $this->userTask);
    }
}