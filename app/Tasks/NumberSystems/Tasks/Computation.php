<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\NumberSystems\NumberSystemTrait;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

//Вычислите значение выражения {number1}{sub}{scale_of_notation1}{sub_end} {sign} {number2}{sub}{scale_of_notation2}{sub_end}
//В ответе запишите вычисленное значение в десятичной системе счисления. Если число дробное округлите до 2 знака.
class Computation implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $sign = $this->signs[rand(0, count($this->signs) - 1)];
        $scale_of_notation1 = $this->getRandomScale(10);
        $scale_of_notation2 = $this->getRandomScale();

        switch ($sign) {
            case '*':
                $number1 = rand(1, 25);
                $number2 = rand($number1, 25);
                break;
            case '/':
                $number1 = round(rand(1, 99) / 2);
                $number2 = round(rand($number1, 100) / 2);
                break;
            case '+':
            case '-':
            default:
                $number1 = rand(1, 99);
                $number2 = rand($number1, 100);
                break;
        }

        $number1 = base_convert($number1, $this->to_ci, $scale_of_notation1);
        $number2 = base_convert($number2, $this->to_ci, $scale_of_notation2);

        $answer1 = base_convert($number1, $scale_of_notation1, $this->to_ci);
        $answer2 = base_convert($number2, $scale_of_notation2, $this->to_ci);

        $this->data = [
            'sign' => $sign,
            'number1' => mb_strtoupper($number1),
            'number2' => mb_strtoupper($number2),
            'scale_of_notation1' => $scale_of_notation1,
            'scale_of_notation2' => $scale_of_notation2,
            'answer1' => $answer1,
            'answer2' => $answer2,
            'format1' => $this->formatNumber($number1, $scale_of_notation1, $this->to_ci, $answer1),
            'format2' => $this->formatNumber($number2, $scale_of_notation2, $this->to_ci, $answer2),
        ];
        return $this->data;
    }

    //Переведите все в десятичную систему исчисления
    //Посчитайте значение выражения
    public function getAnswer()
    {
        $answer1 = base_convert($this->data['number1'], $this->data['scale_of_notation1'], $this->to_ci);
        $answer2 = base_convert($this->data['number2'], $this->data['scale_of_notation2'], $this->to_ci);
        switch ($this->data['sign']) {
            case '-':
                $answer = $answer1 - $answer2;
                break;
            case '*':
                $answer = $answer1 * $answer2;
                break;
            case '/':
                $answer = round($answer1 / $answer2, 2);
                break;
            case '+':
            default:
                $answer = $answer1 + $answer2;
                break;
        }
        return $answer;
    }

    //Переведем числа в десятичную:
    //{number1}{sub}{scale_of_notation1}{sub_end} = {format1_text} = {format1_answer}
    //{number2}{sub}{scale_of_notation2}{sub_end} = {format2_text} = {format2_answer}
    //Перепишем выражение:
    //{format1_answer} {sign} {format2_answer} = {answer}
    public function replaceArray(): array
    {
        return [
            '{number1}' => mb_strtoupper($this->data['number1']),
            '{scale_of_notation1}' => $this->data['scale_of_notation1'],
            '{sign}' => $this->data['sign'],
            '{number2}' => mb_strtoupper($this->data['number2']),
            '{scale_of_notation2}' => $this->data['scale_of_notation2'],
            '{format1_text}' => $this->data['format1']['text'],
            '{format1_answer}' => $this->data['answer1'],
            '{format2_text}' => $this->data['format2']['text'],
            '{format2_answer}' => $this->data['answer2'],
            '{answer}' => $this->getAnswer(),
        ];
    }
}