<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

// Сколько {one_or_zero} в двоичной записи {ci} числа {number}?
class OneOfZero implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

    public function initData()
    {
        $scale_of_notation = $this->getRandomScale(2);
        $number = rand(1, 1000);
        $number = (string)base_convert($number, $this->to_ci, $scale_of_notation);
        $one_or_zero = $this->oneZero[rand(0, 1)];
        $this->data = compact('scale_of_notation', 'number', 'one_or_zero');
        return $this->data;
    }

    //Переведем из {scale_of_notation} в 10, а потом в 2:
    //{format_binary}
    //Ответ: {answer}
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

    // Перевести в десятичную, потом в двоичную и посчитать нули или единицы.
    public function getAnswer()
    {
        $one_or_zero = $this->oneZero[0] == $this->data['one_or_zero'] ? 0 : 1;
        $number = (string)base_convert($this->data['number'], $this->data['scale_of_notation'], 2);
        return mb_substr_count($number, $one_or_zero);
    }
}