<?php


namespace App\Http\Controllers\Tasks;


class GD_Task implements InterfaceTask
{
    public $task_text;
    public $slug;
    public $title;
    public $graph;
    public $graphImg;
    public $tableImg;
    public $classLayout = 'col-md-6';
    public $classLayout2 = 'col-md-6';

    public function __construct($task, $user_task)
    {
        $data = json_decode($user_task->data, true);
        $this->title = $data['title'];
        $this->graph = $data['graph'];
        $this->graphImg = $data['graphImg'];
        $this->tableImg = $data['tableForGraph'];
        $this->task_text = $this->replaceText($task->task_text);
        $this->slug = $this->replaceText($task->slug);
    }

    public function generate()
    {
        $data = get_object_vars($this);
        return $data;
    }

    public function solution()
    {
    }

    public function answer()
    {
    }

    public function replaceText($text)
    {
        $text = str_replace('{graph}', $this->graphImg, $text);
        $text = str_replace('{table}', $this->tableImg, $text);
        return $text;
    }

    public static function getData()
    {
        $title = 'Задание 3';
        $graph = GD_Task::generateGraph();
        $graphImg = GD_Task::generateGraphImg($graph);
        $tableForGraph = GD_Task::generateTable($graph);
        return compact('title', 'graph', 'graphImg', 'tableForGraph');
    }

    public static function generateGraph()
    {
        $vertexCnt = random_int(5, 7);
        $matrix = array_fill(0, $vertexCnt, array_fill(0, $vertexCnt, 0));
        for ($i = 0; $i < $vertexCnt; $i++) {
            $neighborsCnt = random_int(0, $vertexCnt - 1);
            for ($j = 0; $j < $vertexCnt; $j++) {
                if ($j != $i) {
                    if (rand(0, 1) && $neighborsCnt) {
                        $distance = random_int(1, 20);
                        $matrix[$i][$j] = $distance;
                        $matrix[$j][$i] = $distance;
                    }
                    $neighborsCnt -= 1;
                } else {
                    $matrix[$j][$i] = '-';
                }
            }
        }
        return $matrix;
    }

    public static function generateGraphImg($graph)
    {
//        $alpha = getAlpha();
        $width = 500;
        $height = 300;
        $image = imagecreate($width, $height);
        // Задний фон
        imagecolorallocate($image, 255, 255, 255);
        // Цвет текста
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $coordinate = [];
        foreach ($graph as $key => $vertexRow) {
            $coordinate[$key] = [
                'y' => random_int(50, $height - 50),
                'x' => random_int(50, $width - 50)
            ];
            imagestring($image, 10, $coordinate[$key]['x'], $coordinate[$key]['y'], $key + 1, $text_color);
        }
        $lines = [];
        foreach ($graph as $key => $vertexRow) {
            $lines[$key] = [];
            foreach ($vertexRow as $n => $d) {
                if ($n != 0 and $n != '-' and !in_array($n, $lines[$key])) {
                    $lines[$key][] = $n;
                    imageline(
                        $image,
                        $coordinate[$key]['x'] + 10,
                        $coordinate[$key]['y'] + 2,
                        $coordinate[$n]['x'] + 10,
                        $coordinate[$n]['y'] + 2,
                        $text_color
                    );
                }
            }
        }
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        $img = base64_encode($imageData);
        $name = 'Graph';

        return view('components.image', compact('img', 'name'))->render();
    }

    public static function generateTable($graph)
    {
        $result = '<table class="table table-bordered">';
        foreach ($graph as $key => $row) {
            if ($key == 0) {
                $first = ['-'];
                array_walk(
                    $graph,
                    function ($item, $key) use (&$first) {
                        $l = 'П' . ($key + 1);
                        array_push($first, $l);
                    }
                );
                $result .= GD_Task::generateRowTable($first);
            }
            array_unshift($row, 'П' . ($key + 1));
            $result .= GD_Task::generateRowTable($row);
        }

        $result .= '</table>';
        return $result;
    }

    public static function generateRowTable($rowElements, $td = true)
    {
        $td = $td ? 'td' : 'th';
        $row = '<tr>';
        foreach ($rowElements as $element) {
            $row .= '<' . $td . '>' . $element . '</' . $td . '>';
        }
        $row .= '</tr>';
        return $row;
    }
}