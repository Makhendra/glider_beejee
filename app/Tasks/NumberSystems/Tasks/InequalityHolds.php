<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

// Сколько существует целых чисел x, для которых выполняется неравенство 2A16<x<618?
class InequalityHolds implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $scale_of_notation1 = $this->getRandomScale();
        $scale_of_notation2 = $this->getRandomScale();

        $number1 = rand(0, 1000);
        $number2 = rand($number1, 1000);
        $number1 = base_convert($number1, $this->to_ci, $scale_of_notation1);
        $number2 = base_convert($number2, $this->to_ci, $scale_of_notation2);

        $answer1 = base_convert($number1, $scale_of_notation1, $this->to_ci);
        $answer2 = base_convert($number2, $scale_of_notation2, $this->to_ci);

        $this->data = [
            'number1' => $number1,
            'number2' => $number2,
            'scale_of_notation1' => $scale_of_notation1,
            'scale_of_notation2' => $scale_of_notation2,
            'answer1' => $answer1,
            'answer2' => $answer2,
            'format1' => $this->formatNumber($number1, $scale_of_notation1, $this->to_ci, $answer1),
            'format2' => $this->formatNumber($number2, $scale_of_notation2, $this->to_ci, $answer2),
        ];
        return $this->data;
    }


    public function replaceArray(): array
    {
        return [
            '{number1}' => $this->data['number1'],
            '{number2}' => $this->data['number2'],
            '{scale_of_notation1}' => $this->data['scale_of_notation1'],
            '{scale_of_notation2}' => $this->data['scale_of_notation2'],
            '{format1_text}' => $this->data['format1']['text'],
            '{format1_answer}' => $this->data['answer1'],
            '{format2_text}' => $this->data['format2']['text'],
            '{format2_answer}' => $this->data['answer2'],
            '{answer}' => $this->getAnswer(),
        ];
    }

    public function getAnswer()
    {
        $answer1 = base_convert($this->data['number1'], $this->data['scale_of_notation1'], $this->to_ci);
        $answer2 = base_convert($this->data['number2'], $this->data['scale_of_notation2'], $this->to_ci);
        return abs($answer2 - $answer1);
    }
}
