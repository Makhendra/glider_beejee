<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

//Дано {n целых числа}, записанных в {ci} системе: 
//{list_n}
//Сколько среди них чисел, {max_or_min} чем {number}{sub}{scale_of_notation}{sub_end}?
class CountMaxOrMin implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;
    public $classLayout = 'col-md-3';
    public $classLayout2 = 'col-md-9';

    public function initData()
    {
        $n = rand(3, 10);

        $number_origin = rand(1, 1000);
        $scale_of_notation = $this->getRandomScale();
        $number_scale = base_convert($number_origin, $this->to_ci, $scale_of_notation);
        $number = compact('number_origin', 'number_scale', 'scale_of_notation');

        $list_n = [
            'list' => [],
            'scale_of_notation' => $this->getRandomScale(10)
        ];
        $max_or_min = $this->maxOrMinText[rand(0, 1)];
        for ($i = 0; $i < $n; $i++) {
            $number_origin = rand(1, 1000);
            $number_scale = base_convert($number_origin, $this->to_ci, $list_n['scale_of_notation']);
            $list_n['list'][] = compact('number_origin', 'number_scale');
        }
        $this->data = compact('n', 'list_n', 'max_or_min', 'number');
        return $this->data;
    }

    //Переведем изначальное число в десятичную СИ:
    //{number}{sub}{scale_of_notation}{sub_end} = {number_format} = {number_to_demical}
    //Переведем все остальные в десятичную:
    // {list_n_to_demical}
    //Подходят под условие {check_list_n}
    //Ответ: {answer}
    public function replaceArray(): array
    {
        list($list_n, $list_n_decimal) = $this->getLists(
            $this->data['list_n']['list'] ?? [],
            $this->data['list_n']['scale_of_notation']
        );
        $answer = 0;
        $max_or_min = $this->data['max_or_min'] == $this->maxOrMinText[0] ? 1 : 0;
        $checkListN = [];
        foreach ($this->data['list_n']['list'] as $element) {
            if ($max_or_min) {
                //Наибольшее
                if ($element['number_origin'] > $this->data['number']['number_origin']) {
                    $answer += 1;
                    $checkListN[] = $element['number_origin'];
                }
            } else {
                //Наименьшее
                if ($element['number_origin'] < $this->data['number']['number_origin']) {
                    $answer += 1;
                    $checkListN[] = $element['number_origin'];
                }
            }
        }
        $checkListN = implode(', ', $checkListN);

        return [
            '{n целых числа}' =>  $this->data['n'].' целых '.trans_choice('число|числа|чисел', $this->data['n']),
            '{ci}' => $this->formats2[$this->data['list_n']['scale_of_notation']],
            '{list_n}' => $list_n,
            '{max_or_min}' => $this->data['max_or_min'],

            '{number}' => $this->data['number']['number_scale'],
            '{scale_of_notation}' => $this->data['number']['scale_of_notation'],

            '{number_to_demical}' => $this->data['number']['number_origin'],
            '{number_format}' => $this->formatNumber(
                $this->data['number']['number_scale'],
                $this->data['number']['scale_of_notation'],
                $this->to_ci,
                ''
            )['text'],
            '{list_n_to_demical}' => $list_n_decimal,
            '{check_list_n}' => $checkListN,
            '{answer}' => $answer,
        ];
    }

    //Перевести все числа в одну систему исчисления
    //Сравнить с исходным
    //Посчитать сколько подходят под условие
    public function getAnswer()
    {
        $answer = 0;
        $max_or_min = $this->data['max_or_min'] == $this->maxOrMinText[0] ? 1 : 0;
        foreach ($this->data['list_n']['list'] as $element) {
            if ($max_or_min) {
                //Наибольшее
                if ($element['number_origin'] > $this->data['number']['number_origin']) {
                    $answer += 1;
                }
            } else {
                //Наименьшее
                if ($element['number_origin'] < $this->data['number']['number_origin']) {
                    $answer += 1;
                }
            }
        }
        return $answer;
    }
}