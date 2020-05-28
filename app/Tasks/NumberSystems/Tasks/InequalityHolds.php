<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

// Сколько целых чисел x, для которых выполняется неравенство
// {number1}{sub}{scale_of_notation1}{sub_end} < x < {number2}{sub}{scale_of_notation2}{sub_end} ?
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


    //Переведем в десятичную СИ
    //
    //{number1}{sub}{scale_of_notation1}{sub_end} = {format1_text} = {format1_answer}
    //
    //{number2}{sub}{scale_of_notation2}{sub_end} = {format2_text} = {format2_answer}
    //
    //Теперь наше неравенство будет выглядеть так: {format1_answer} < x < {format2_answer}
    //
    //Следовательно, существует {answer} целых чисел, для которых это неравенство выполнится.
    //
    //Ответ: {answer}
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


    //Для решения этой задачи необходимо:
    //
    //Перевести в десятичную систему счисления числа из неравенства
    //Переписать неравенство и посчитать количество чисел
    public function getAnswer()
    {
        $answer1 = base_convert($this->data['number1'], $this->data['scale_of_notation1'], $this->to_ci);
        $answer2 = base_convert($this->data['number2'], $this->data['scale_of_notation2'], $this->to_ci);
        return abs($answer2 - $answer1);
    }
}
