<?php


namespace App\Tasks\NumberSystems;


use App\Http\Controllers\TaskController;
use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use Illuminate\Http\Request;

// Все 4-буквенные слова, составленные из букв Д, Е, К, О, Р, записаны в алфавитном порядке и пронумерованы, начиная с 1.
// Ниже приведено начало списка. 1. ДДДД 2. ДДДЕ 3. ДДДК 4. ДДДО 5. ДДДР 6. ДДЕД ...
// Под каким номером в списке идёт первое слово, которое начинается с буквы K?
class FW_Task implements TaskInterface
{
    use TaskTrait, NumberSystemService;

    public function initData()
    {
        $count_chars = (int)rand(3, 5);
        $count_letters = (int)rand(3, $count_chars);
        $letters = $this->generateList($count_letters);
        $list = $this->generateListWordLetters($letters, $count_letters, $count_chars);
        $number_letter = rand(1, $count_letters - 1);
        $letter = $letters[$number_letter];
        $this->data = compact('count_letters', 'count_chars', 'letters', 'letter', 'list', 'number_letter');
        return $this->data;
    }

    public function replaceArray(): array
    {
        $letters = implode(', ', $this->data['letters']);
        $list = array_map(
            function ($item, $key) {
                return $key . '. ' . $item;
            },
            $this->data['list'],
            range(1, count($this->data['list']))
        );
        $list = implode(',<br> ', $list);
        $allCountWord = pow($this->data['count_chars'], $this->data['count_letters']);
        return [
            '{count_letters}' => $this->data['count_letters'],
            '{count_chars}' => $this->data['count_chars'],
            '{letters}' => $letters,
            '{letter}' => $this->data['letter'],
            '{list}' => $list,
            '{all_count_word}' => $allCountWord ,
            '{answer}' => $this->getAnswer()
        ];
    }

    public function getAnswer()
    {
        $allCountWord = pow($this->data['count_chars'], $this->data['count_letters']);
        return ($allCountWord / $this->data['count_chars']) * ($this->data['count_letters'] - 1) + 1;
    }

}
