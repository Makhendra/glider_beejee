<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

// Укажите количество целых десятичных чисел из диапазона от 39 до 49 включительно,
// имеющих в своей двоичной записи более 3 единиц.
class NumbersFormTheRange implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $number1 = rand(1, 50);
        $number = (string)base_convert($number1, $this->to_ci, 2);
        $one_or_zero = random_int(0, 1);
        $n = random_int(1, mb_strlen($number) - 1);
        $this->data = [
            'number1' => $number1,
            'number2' => ($number1 + 10),
            'n' => $n,
            'one_or_zero' => $this->oneZero[$one_or_zero],
        ];
        return $this->data;
    }

    public function replaceArray(): array
    {
        $number_list = [];
        $answer = $this->getAnswer($number_list);
        $number_list = implode(',<br> ', $number_list);
        return [
            '{number1}' => $this->data['number1'],
            '{number2}' => $this->data['number2'],
            '{n}' => $this->data['n'],
            '{one_or_zero}' => $this->data['one_or_zero'],
            '{answer}' => $answer,
            '{number_list}' => $number_list,
        ];
    }

    public function getAnswer(&$list = null)
    {
        $one_or_zero = $this->oneZero[0] == $this->data['one_or_zero'] ? 0 : 1;
        $answer = 0;
        $start = $this->data['number1'];
        while( $start < $this->data['number2']) {
            $number = (string)base_convert($start, $this->to_ci, 2);
            $list[] = $start.' – '.$number;
            $cnt = mb_substr_count($number, $one_or_zero);
            if ($cnt >= $this->data['n']) {
                $answer += 1;
            };
            $start += 1;
        }
        return $answer;
    }
}