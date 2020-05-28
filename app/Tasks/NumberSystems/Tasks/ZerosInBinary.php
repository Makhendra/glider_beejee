<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

//Сколько значащих нулей в двоичной записи значения выражения {expression}?
//В ответе запишите только целое округленное число.
class ZerosInBinary implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $expression = $this->getRandomExpression();
        $this->data = $expression;
        return $this->data;
    }

    //Переведем все числа в одну систему исчисления, для простоты в десятичную:
    //{decimal_list}
    //Новое выражение будет выглядеть:
    //{decimal_expression} = {decimal_expression_answer}
    //Переведем в двоичную СИ:
    //{decimal_expression_answer} = {binary_expression_format}
    //Ответ: {answer}
    public function replaceArray(): array
    {
        $decimal_list = [];
        foreach ($this->data['elements'] as $element) {
            $l = $element['number_scale'] . '<sub>' . $element['scale_of_notation'] . '</sub> = ';
            $l .= $this->formatNumber(
                $element['number_scale'],
                $element['scale_of_notation'],
                $this->to_ci,
                ''
            )['text'];
            $l .= '=' . $element['number_origin'];
            $decimal_list[] = $l;
        }
        $decimal_list = implode('<br>', $decimal_list);
        return [
            '{expression}' => $this->data['expression'],
            '{decimal_list}' => $decimal_list,
            '{decimal_expression}' => $this->data['decimal_expression'],
            '{decimal_expression_answer}' => $this->getDecimal(),
            '{binary_expression_format}' => $this->toBinary(),
            '{answer}' => $this->getAnswer()
        ];
    }

    public function getDecimal()
    {
        $decimal = $this->data['decimal_expression'] ?? '';
        $value = eval('return '.$decimal.';');
        return round($value);
    }

    public function toBinary()
    {
        $decimal = str_replace('-', '', $this->getDecimal());
        return base_convert($decimal, $this->to_ci, 2);
    }

    //Для решения этой задачи необходимо:
    //Перевести все в одну систему исчисления
    //Посчитать значение выражения
    //Перевести его в двоичную СИ
    public function getAnswer()
    {
        return mb_substr_count($this->toBinary(), 0);
    }
}