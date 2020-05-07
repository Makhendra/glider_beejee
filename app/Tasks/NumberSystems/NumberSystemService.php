<?php

namespace App\Tasks\NumberSystems;

trait NumberSystemService
{
    public $to_ci = 10;

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
}