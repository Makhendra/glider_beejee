<?php

namespace App\Tasks\NumberSystems;

trait NumberSystemService
{
    public $to_ci = 10;
    public $signs = ['+', '-', '*', '/'];
    public $oneZero = ['нулей', 'единиц'];

    public function generateList($count_letters) {
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
}