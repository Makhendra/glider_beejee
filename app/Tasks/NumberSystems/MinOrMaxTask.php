<?php


namespace App\Tasks\NumberSystems;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

//Дано n выражения(ий):
//Какое из них имеет наибольшее значение?
class MinOrMaxTask implements TaskInterface
{
    use TaskTrait, NumberSystemService;

    public function initData()
    {
        $n = random_int(3, 10);
        $list_n = [];
        $max_or_min = $this->maxOrMin[random_int(0, 1)];
        for ($i = 0; $i < $n; $i++) {
            $scale_of_notation = $this->getRandomScale(2);
            $number_origin = rand(1, 1000);
            $number_scale = base_convert($number_origin, $this->to_ci, $scale_of_notation);
            $list_n[] = compact('number_origin', 'number_scale', 'scale_of_notation');
        }
        $this->data = compact('n', 'list_n', 'max_or_min');
        return $this->data;
    }

    public function replaceArray(): array
    {
        $answer = 0;
        list($list_n, $list_n_decimal) = $this->getLists($this->data['list_n']);
        $max_or_min = $this->data['max_or_min'] == $this->maxOrMin[0] ? 1 : 0;
        foreach ($this->data['list_n'] as $key => $element) {
            if($max_or_min) {
                //Наибольшее
                if($element['number_origin'] > $answer) {
                    $answer = $element['number_origin'];
                }
            } else {
                //Наименьшее
                if($element['number_origin'] < $answer) {
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

    public function getAnswer()
    {
        $values = array_column($this->data['list_n'], 'number_origin');
        rsort($values);
        return array_shift($values);
    }
}