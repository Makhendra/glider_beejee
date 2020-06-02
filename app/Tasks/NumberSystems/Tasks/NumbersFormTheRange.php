<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

//Укажите количество целых десятичных чисел из диапазона от {number1} до {number2} включительно,
//имеющих в своей двоичной записи больше либо равно {one_or_zero}.
class NumbersFormTheRange implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $number1 = rand(1, 50);
        $number = (string)base_convert($number1, $this->to_ci, 2);
        $one_or_zero = rand(0, 1);
        $n = rand(1, mb_strlen($number) - 1);
        $this->data = [
            'number1' => $number1,
            'number2' => ($number1 + 10),
            'n' => $n,
            'one_or_zero' => $this->oneZero[$one_or_zero],
        ];
        return $this->data;
    }

    //Переведем все числа из диапазона:
    //{number_list}
    //
    //Ответ: {answer}
    public function replaceArray(): array
    {
        $one_or_zero = $this->oneZero[0] == $this->data['one_or_zero'] ? 0 : 1;
        if($one_or_zero == 0) {
            $nOneOrZero = trans_choice('ноль|ноля|нулей', $one_or_zero);
        } else {
            $nOneOrZero = trans_choice('единицу|единицы|единиц', $one_or_zero);
        }
        $number_list = [];
        $answer = $this->getAnswer($number_list);
        $number_list = implode(',<br> ', $number_list);
        return [
            '{number1}' => $this->data['number1'],
            '{number2}' => $this->data['number2'],
            '{n}' => $this->data['n'],
            '{one_or_zero}' => $this->data['one_or_zero'],
            '{n_one_or_zero}'=> $nOneOrZero,
            '{answer}' => $answer,
            '{number_list}' => $number_list,
        ];
    }

    //Переведите все числа из диапазона в двоичную систему исчисления
    //Посчитайте числа подходящие под условия
    public function getAnswer(&$list = null)
    {
        $one_or_zero = $this->oneZero[0] == $this->data['one_or_zero'] ? 0 : 1;
        $answer = 0;
        $start = $this->data['number1'];
        while( $start < $this->data['number2']) {
            $number = (string)base_convert($start, $this->to_ci, 2);
            $list[] = $start.' – '.$number;
            $cnt = mb_substr_count($number, $one_or_zero);
            if ($cnt > $this->data['n']) {
                $answer += 1;
            }
            $start += 1;
        }
        return $answer;
    }
}