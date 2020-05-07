<?php


namespace App\Tasks\Graphs;


class GraphTableService
{
    public function getTable($graph)
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
                $result .= $this->generateRowTable($first);
            }
            array_unshift($row, 'П' . ($key + 1));
            $result .= $this->generateRowTable($row);
        }

        $result .= '</table>';
        return $result;
    }

    public  function generateRowTable($rowElements, $td = true)
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