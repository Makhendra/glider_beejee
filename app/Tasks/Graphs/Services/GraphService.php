<?php


namespace App\Tasks\Graphs\Services;

use App\Tasks\Graphs\Services\Dijkstra;

class GraphService
{
    public $alpha;
    public $matrix;

    public function __construct()
    {
        $this->alpha = getAlpha();
        $this->matrix = [];
    }

    public function generateGraph($min = 1)
    {
        $vertexCnt = rand(5, 7);
        $neighborsCnt = rand($min, $vertexCnt - 1);

        for ($i = 0; $i < $vertexCnt; $i++) {
            $j = rand(0, $vertexCnt - 1);
            $charI = $this->alpha[$i];
            $this->matrix[$charI] = isset($this->matrix[$charI]) ? $this->matrix[$charI] : [];
            $this->addNeighsBorgs($i, $j, $neighborsCnt);
        }
        while($neighborsCnt > 0) {
            $i = rand(0, $vertexCnt - 1);
            $j = rand(0, $vertexCnt - 1);
            $charI = $this->alpha[$i];
            $this->matrix[$charI] = isset($this->matrix[$charI]) ? $this->matrix[$charI] : [];
            $this->addNeighsBorgs($i, $j, $neighborsCnt);
        }
        return $this->matrix;
    }

    public function addNeighsBorgs($i, $j, &$neighborsCnt) {
        $charI = $this->alpha[$i];
        if ($j != $i) {
            $charJ = $this->alpha[$j];
            $isNeedCreate = rand(0, 1);
            if ($isNeedCreate && $neighborsCnt) {
                $this->addEdge($charI, $charJ);
                $neighborsCnt -= 1;
            }
        }
    }

    public function addEdge($a, $b)
    {
        $distance = rand(1, 20);
        $this->matrix[$a][$b] = $distance;
        $this->matrix[$b][$a] = $distance;
    }

    public function checkPath($start, $end)
    {
        if (!isset($this->matrix[$start][$end]) ? true : $this->matrix[$start][$end] == 0) {
            if (!$this->hasPath($start, $end)) {
                $this->addEdge($start, $end);
            }
        }
    }

    public function setMatrix($matrix)
    {
        $this->matrix = $matrix;
    }

    public function getDistance($start, $end) {
        $algorithm = new Dijkstra($this->matrix);
        $algorithm->shortestPaths($start, $end);
        return $algorithm->distance[$end];
    }

    public function getFormatPaths($start, $end)
    {
        $algorithm = new Dijkstra($this->matrix);
        $paths = $algorithm->shortestPaths($start, $end);
        $paths = array_map(
            function ($item) {
                return implode('=>', $item);
            },
            $paths
        );
        return implode('<br>', $paths);
    }

    public function getPoints($randomKeys)
    {
        $points = [];
        array_walk(
            $randomKeys,
            function ($item, $key) use (&$points) {
                $points[$key] = ($key + 1) . ' – ' . $item;
            }
        );
        return implode(', ', $points);
    }

    public function hasPath($start, $end)
    {
        $d = new Dijkstra($this->matrix);
        $d->shortestPaths($start, $end);
        return $d->distance[$end] != INF;
    }
}