<?php


namespace App\Tasks\Graphs;


class GraphService
{

    public function generateGraph()
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
                    $matrix[$j][$i] = 0;
                }
            }
        }
        return $matrix;
    }
}