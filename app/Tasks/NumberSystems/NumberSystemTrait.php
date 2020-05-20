<?php

namespace App\Tasks\NumberSystems;

trait NumberSystemTrait
{
    public $to_ci = 10;
    public $signs = ['+', '-', '*', '/'];
    public $oneZero = ['нулей', 'единиц'];
    public $maxOrMin = ['наибольшее', 'наименьшее'];
    public $maxOrMinText = ['больше', 'меньше'];
    public $formats = [
        '0',
        '1',
        'двоичного',
        'троичного',
        'четверичного',
        'пятеричного',
        'шестеричного',
        'семеричного',
        'восьмеричного',
        'девятеричного',
        'десятичного',
        'одинацатиричного',
        'двенадцатиричного',
        'тринадцатеричного',
        'четырнадцатеричного',
        'пятнадцятиричного',
        'шестнадцатиричного',
    ];

    public function generateList($count_letters)
    {
        $alpha = getAlpha();
        $letters = [];
        $unique = [];
        $i = 0;
        while ($i != $count_letters) {
            $j = rand($i, count($alpha) - 1);
            if (!in_array($j, $unique)) {
                $unique[] = $j;
                $letters[] = $alpha[$j];
                $i += 1;
            }
        }
        sort($letters);
        return $letters;
    }

    public function generateListWordLetters($letters, $count_letters, $count_chars)
    {
        $list = [];
        $w = 0;
        for ($i = 0; $i < $count_letters + 1; $i++) {
            $word = str_pad(base_convert($w, 10, $count_letters), $count_chars, '0', STR_PAD_LEFT);
            foreach ($letters as $digit => $character) {
                $word = str_replace($digit, $character, $word);
            }
            $w += 1;
            $list[] = $word;
        }
        return $list;
    }

    public function formatNumber($number, $from_ci, $to_ci, $answer)
    {
        $text = '';
        $number_array = str_split($number);

        if (in_array($from_ci, $number_array) or $number == $from_ci) {
            return ['text' => 'Перевод невозможен', 'answer_format' => 'Ошибка', 'answer' => 0];
        }
        $high_power = count($number_array);
        foreach ($number_array as $key => $number_string) {
            if (in_array($number_string, ['A', 'B', 'C', 'D', 'E', 'F'])) {
                $number_string = base_convert($number_string, $from_ci, $to_ci);
            }
            $power = $high_power - $key - 1;
            $text .= "$number_string × $from_ci<sup>^$power</sup>";
            if ($key + 1 != $high_power) {
                $text .= '+';
            }
        }
        return ['text' => $text, 'answer_format' => $answer . "<sub>$to_ci</sub>", 'answer' => $answer];
    }

    public function getRandomScale($offset = false) {
        $scales = [2, 4, 8, 10, 16];
        if($offset){
            $index = array_search($offset, $scales);
            if($index !== false) {
                unset($scales[$index]);
            }
        }

        return $scales[random_int(0, count($scales) - 1)];
    }

    public function formatToBinary($number, $from_ci) {
        $answer = base_convert($number, $from_ci, $this->to_ci);
        $format = $this->formatNumber($number, $from_ci, $this->to_ci, $answer);
        if(in_array($from_ci, [4, 8, 16])) {
            $text = $number. ' = '. $format['text']. ' = '. $format['answer_format'].'<br><br>';
        } else {
            $text = 'Число уже в десятичной системе исчисления.<br><br>';
        }
        $text .= $this->deleting($answer, 2);
        return $text;
    }

    public function deleting($number, $ci) {
        $deleting = '';
        while( $number > 0) {
            $div = intdiv($number, $ci);
            $mod = $number % $ci;
            $deleting .= "$number/$ci=$div, остаток $mod <br>";
            $number = $div;
        }
        return $deleting;
    }

    public function getLists($list, $scale_of_notation = false) {
        $list_n = [];
        $list_n_decimal = [];
        $scale_of_notation = $scale_of_notation ?: $list[0]['scale_of_notation'];
        foreach ($list as $key => $element) {
            $list_n[] = $element['number_scale'] . '<sub>' . $scale_of_notation . '</sub>';
            $format = $this->formatNumber(
                $element['number_scale'],
                $scale_of_notation,
                $this->to_ci,
                $element['number_origin']
            );
            $list_n_decimal[] = $list_n[$key] . ' = ' . $format['text'] . ' = ' . $format['answer_format'];
        }
        $list_n = implode('<br>', $list_n);
        $list_n_decimal = implode('<br>', $list_n_decimal);
        return [$list_n, $list_n_decimal];
    }

    public function formatAnswer($number, $from_ci, $to_ci) {
        $answer = base_convert($number, $from_ci, $to_ci);
        if($from_ci > $to_ci) {
            return $this->deleting($number, $to_ci);
        } else {
            $format= $this->formatNumber($number, $from_ci, $to_ci, $answer);
            return $format['text'].'='.$format['answer_format'];
        }
    }
}