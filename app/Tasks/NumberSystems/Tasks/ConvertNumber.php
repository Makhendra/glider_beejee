<?php

namespace App\Tasks\NumberSystems\Tasks;

use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

//Переведите число {number}{sub}{scale_notation1}{sub_end} в систему счисления с основанием {scale_notation2}.
class ConvertNumber implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $number = rand(1, 200);
        $scale_notation1 = $this->getRandomScale();
        $number = base_convert($number, $this->to_ci, $scale_notation1);
        $scale_notation2 = $this->getRandomScale($scale_notation1);
        $this->data = compact('number', 'scale_notation1', 'scale_notation2');
        return $this->data;
    }

    //Перевод:
    //{format_answer}
    //Ответ: {answer}
    public function replaceArray(): array
    {
        return [
            '{number}' => mb_strtoupper($this->data['number']),
            '{scale_notation1}' => $this->data['scale_notation1'],
            '{scale_notation2}' => $this->data['scale_notation2'],
            '{format_answer}' => $this->formatAnswer(
                $this->data['number'],
                $this->data['scale_notation1'],
                $this->data['scale_notation2']
            ),
            '{answer}' => $this->getAnswer(),
        ];
    }

    //Проще всего переводить все в 10 СИ и из нее в нужную.
    public function getAnswer()
    {
        return base_convert($this->data['number'], $this->data['scale_notation1'], $this->data['scale_notation2']);
    }
}