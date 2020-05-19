<?php


namespace App\Tasks\NumberSystems;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;

// Сколько единиц в двоичной записи шестнадцатиричного числа 155?
class OneOfZeroTask implements TaskInterface
{
    use TaskTrait, NumberSystemService;

    public function initData()
    {
        $scale_of_notation = $this->getRandomScale();
        $number = rand(1, 1000);
        $number = (string)base_convert($number, $this->to_ci, $scale_of_notation);
        $one_or_zero = $this->oneZero[random_int(0, 1)];
        $this->data = compact('scale_of_notation', 'number', 'one_or_zero');
        return $this->data;
    }

    public function replaceArray(): array
    {
        return [
            '{number}' => $this->data['number'],
            '{ci}' => $this->formats[$this->data['scale_of_notation']],
            '{scale_of_notation}' => $this->data['scale_of_notation'],
            '{one_or_zero}' => $this->data['one_or_zero'],
            '{format_binary}' => $this->formatToBinary($this->data['number'], $this->data['scale_of_notation']),
            '{answer}' => $this->getAnswer(),
        ];
    }

    public function getAnswer()
    {
        $one_or_zero = $this->oneZero[0] == $this->data['one_or_zero'] ? 0 : 1;
        $number = (string)base_convert($this->data['number'], $this->data['scale_of_notation'], 2);
        return mb_substr_count($number, $one_or_zero);
    }
}