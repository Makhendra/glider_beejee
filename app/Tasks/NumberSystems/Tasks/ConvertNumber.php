<?php

namespace App\Tasks\NumberSystems\Tasks;

use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

//Переведите число 10100102 в систему счисления с основанием 10.
class ConvertNumber implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $number = random_int(1, 200);
        $scale_notation1 = $this->getRandomScale();
        $number = base_convert($number, $this->to_ci, $scale_notation1);
        $scale_notation2 = $this->getRandomScale($scale_notation1);
        $this->data = compact('number', 'scale_notation1', 'scale_notation2');
        return $this->data;
    }

    public function replaceArray(): array
    {
        return [
            '{number}' => $this->data['number'],
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

    public function getAnswer()
    {
        return base_convert($this->data['number'], $this->data['scale_notation1'], $this->data['scale_notation2']);
    }
}