<?php


namespace App\Tasks\NumberSystems\Tasks;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use App\Tasks\NumberSystems\NumberSystemTrait;

//Все {count_letters}-буквенные слова, составленные из букв {letters},
//записаны в алфавитном порядке и пронумерованы, начиная с 1.
//Ниже приведено начало списка.
//{list}
//Под каким номером в списке идёт первое слово, которое начинается с буквы {letter}?
class NumberInTheList implements TaskInterface
{
    use TaskTrait, NumberSystemTrait;

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

    //Из {count_chars} букв можно составить {count_chars}{sup}{count_letters}{sup_end} = {all_count_word} слов.
    //
    //Т. к. слова идут в алфавитном порядке, то на каждую букву приходиться {count_row} строк.
    //
    //Буква {letter} - {n} в алфавите. 
    //
    //Ответ: {count_row} * {n} + 1 = {answer}.
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
        $allCountWord = pow($this->data['count_letters'], $this->data['count_chars']);
        return [
            '{count_letters}' => $this->data['count_letters'],
            '{count_chars}' => $this->data['count_chars'],
            '{letters}' => $letters,
            '{letter}' => $this->data['letter'],
            '{list}' => $list,
            '{all_count_word}' => $allCountWord,
            '{count_row}' => $allCountWord / $this->data['count_letters'],
            '{n}' => $this->data['number_letter'] + 1,
            '{answer}' => $this->getAnswer()
        ];
    }

    //Для решения задания, необходимо:
    //
    //Посчитать сколько всего слов
    //Посчитать сколько строк приходится на одну букву
    //Посчитать ответ
    //Не забыть прибавить 1
    public function getAnswer()
    {
        $allCountWord = pow($this->data['count_letters'], $this->data['count_chars']);
        return ($allCountWord / $this->data['count_letters']) * ($this->data['number_letter'] + 1) + 1;
    }

}
