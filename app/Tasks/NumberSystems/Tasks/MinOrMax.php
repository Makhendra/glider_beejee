<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

//Дано {n} выражений:
//{list_n}
//Какое из них имеет {max_or_min} значение? В ответе запишите десятичное число
class MinOrMax implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $n = rand(3, 10);
        $list_n = [];
        $max_or_min = $this->maxOrMin[rand(0, 1)];
        for ($i = 0; $i < $n; $i++) {
            $scale_of_notation = $this->getRandomScale(10);
            $number_origin = rand(1, 1000);
            $number_scale = mb_strtoupper(base_convert($number_origin, $this->to_ci, $scale_of_notation));
            $list_n[] = compact('number_origin', 'number_scale', 'scale_of_notation');
        }
        $this->data = compact('n', 'list_n', 'max_or_min');
        return $this->data;
    }

    //Переведем все выражения в десятичную:
    //{list_n_decimal}
    //Ответ: {max_or_min} значение у {answer}
    public function replaceArray(): array
    {
        list($list_n, $list_n_decimal) = $this->getLists($this->data['list_n']);
        $max_or_min = $this->data['max_or_min'] == $this->maxOrMin[0] ? 1 : 0;
        $answer = $max_or_min ? PHP_INT_MIN: PHP_INT_MAX;
        foreach ($this->data['list_n'] as $key => $element) {
            if ($max_or_min) {
                //Наибольшее
                if ($element['number_origin'] > $answer) {
                    $answer = $element['number_origin'];
                }
            } else {
                //Наименьшее
                if ($element['number_origin'] < $answer) {
                    $answer = $element['number_origin'];
                }
            }
        }
        return [
            '{n}' => $this->data['n'],
            '{list_n}' => $list_n,
            '{list_n_decimal}' => $list_n_decimal,
            '{max_or_min}' => $this->data['max_or_min'],
            '{answer}' => $answer,
        ];
    }

    // Перевести все выражения в одну систему исчисления, проще всего в десятичную и найдите выражение удовлетворяющее заданию.
    public function getAnswer()
    {
        $values = array_column($this->data['list_n'], 'number_origin');
        $max_or_min = $this->data['max_or_min'] == $this->maxOrMin[0] ? 1 : 0;
        if($max_or_min) {
            rsort($values);
        } else {
            sort($values);
        }
        return array_shift($values);
    }
}