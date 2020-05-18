<?php


namespace App\Tasks\NumberSystems;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

class ComputationTask implements TaskInterface
{
    use TaskTrait, NumberSystemService;

    public function initData()
    {
        $sign = $this->signs[random_int(0, count($this->signs) -1 )];
        $scale_of_notation1 = (int)rand(2, 16);
        $scale_of_notation2 = (int)rand(2, 16);

        $number1 = rand(1, 1000);
        $number2 = rand($number1, 1000);
        $number1 = base_convert($number1, $this->to_ci, $scale_of_notation1);
        $number2 = base_convert($number2, $this->to_ci, $scale_of_notation2);

        $answer1 = base_convert($number1, $scale_of_notation1, $this->to_ci);
        $answer2 = base_convert($number2, $scale_of_notation2, $this->to_ci);

        $this->data = [
            'sign' => $sign,
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
            case '*':
                $answer = $answer1 / $answer2;
                break;
            case '+':
            default:
                $answer = $answer1 + $answer2;
                break;
        }
        return $answer;
    }

    public function replaceArray(): array
    {
        return [
            '{number1}' => $this->data['number1'],
            '{scale_of_notation1}' => $this->data['scale_of_notation1'],
            '{sign}' => $this->data['sign'],
            '{number2}' => $this->data['number2'],
            '{scale_of_notation2}' => $this->data['scale_of_notation2'],
            '{format1_text}' => $this->data['format1']['text'],
            '{format1_answer}' => $this->data['answer1'],
            '{format2_text}' => $this->data['format2']['text'],
            '{format2_answer}' => $this->data['answer2'],
            '{answer}' => $this->getAnswer(),
        ];
    }
}