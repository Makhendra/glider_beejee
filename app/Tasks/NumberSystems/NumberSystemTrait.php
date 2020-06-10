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

    public $formats2 = [
        '0',
        '1',
        'двоичной',
        'троичной',
        'четверичной',
        'пятеричной',
        'шестеричной',
        'семеричной',
        'восьмеричной',
        'девятеричной',
        'десятичной',
        'одинацатиричной',
        'двенадцатиричной',
        'тринадцатеричной',
        'четырнадцатеричной',
        'пятнадцятиричной',
        'шестнадцатиричной',
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

        if (in_array($from_ci, $number_array)) {
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
        return ['text' => $text, 'answer_format' => mb_strtoupper($answer) . "<sub>$to_ci</sub>", 'answer' => mb_strtoupper($answer)];
    }

    public function getRandomScale($offset = false) {
        $scales = [2, 4, 8, 10, 16];
        if($offset){
            $index = array_search($offset, $scales);
            if($index !== false) {
                unset($scales[$index]);
            }
        }
        sort($scales);

        return $scales[rand(0, count($scales) - 1)];
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
        $binaryAnswer = base_convert($answer, $this->to_ci, 2);
        $text .= '<br> Получилось '.$binaryAnswer;
        return $text;
    }

    public function deleting($number, $ci) {
        $deleting = '<br>';
        while( $number > 0) {
            $div = intdiv($number, $ci);
            $mod = $number % $ci;
            $deleting .= "$number/$ci=$div, остаток $mod <br>";
            $number = $div;
        }
        return $deleting;
    }

    public function getFormatListN($list, $scale_of_notation = false) {
        $list_n = [];
        foreach ($list as $key => $element) {
            $list_n[] = $element['number_scale'] . '<sub>' . $scale_of_notation . '</sub>';
        }
        return implode('<br>', $list_n);
    }

    public function getLists($list, $scale_of_notation = false) {
        $list_n = [];
        $list_n_decimal = [];
        foreach ($list as $key => $element) {
            $scale_of_notation = $list[$key]['scale_of_notation'] ?? $scale_of_notation;
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
        if($from_ci > $to_ci) {
            $text = '';
            if($from_ci != 10) {
                $numberDemical = base_convert($number, $from_ci, $this->to_ci);
                $textFormat = $this->formatNumber($numberDemical, $this->to_ci, $to_ci, '');
                $text = $this->wrapScaleNumber($number, $from_ci).' = '.$textFormat['text']. ' = '.$numberDemical.'<sub>10</sub><br>';
                $number = $numberDemical;
            }
            if($to_ci != 10) {
                $text .= $this->deleting($number, $to_ci);
            }
            return $text;
        } else {
            $answer = base_convert($number, $from_ci, $to_ci);
            $format= $this->formatNumber($number, $from_ci, $to_ci, $answer);
            return $format['text'].'='.$format['answer_format'];
        }
    }

    public function wrapScaleNumber($number, $from_ci) {
        return mb_strtoupper($number).'<sub>'.$from_ci.'</sub>';
    }

    public function getRandomExpression() {
        $expression = [];
        $cntElements = rand(2, 6);
        $cntBrackets = 0;
        $open = true;
        $next = true;
        if($cntElements > 2) {
            $cntBrackets = rand(0, $cntElements - 2) * 2;
        }
        $expression['expression'] = '';
        $expression['decimal_expression'] = '';
        for ($i = 0; $i < $cntElements; $i++) {
            $scale_of_notation = $this->getRandomScale();
            $number_origin = round(rand(1, 1000) / 2);
            $number_scale = base_convert($number_origin, $this->to_ci, $scale_of_notation);
            $expression['elements'][$i] = compact('number_origin', 'number_scale', 'scale_of_notation');
            $expression['decimal_expression'] .= $number_origin;
            $expression['expression'] .= mb_strtoupper($number_scale.'<sub>'.$scale_of_notation.'</sub>');
            if($cntBrackets && $next) {
                $cntBrackets -= 1;
                if($open) {
                    if($i < $cntElements - 1) {
                        $expression['signs'][$i] = $this->signs[rand(0, count($this->signs) - 1 )];
                        $expression['expression'] .= $expression['signs'][$i];
                        $expression['decimal_expression'] .= $expression['signs'][$i];
                    }
                    $expression['expression'] .= '(';
                    $expression['decimal_expression'] .= '(';
                } else {
                    $expression['expression'] .= ')';
                    $expression['decimal_expression'] .= ')';
                    if($i < $cntElements - 1) {
                        $sign= $this->signs[rand(0, count($this->signs) - 1 )];
                        $expression['expression'] .= $sign;
                        $expression['decimal_expression'] .= $sign;
                    }
                }
                $open = !$open;
                $next = false;
            } else {
                $next = true;
                if($i < $cntElements - 1) {
                    $sign = $this->signs[rand(0, count($this->signs) - 1 )];
                    $expression['expression'] .= $sign;
                    $expression['decimal_expression'] .= $sign;
                }
            }

        }
        if($open == false) {
            $expression['expression'] .= ')';
            $expression['decimal_expression'] .= ')';
        }
        $expression = str_replace('()', '', $expression);
        return $expression;
    }

    public function formatTernary($number, $from_ci, $to_ci) {
        if(in_array($from_ci, [4, 8, 16])) {
            $result = 'Перевод с помощью треад/тетрад:<br>';
            $d = $this->getCountBinaryDigit($from_ci);
            $number_array = str_split($number);
            foreach ($number_array as $k => $n) {
                $answer = base_convert($n, $from_ci, 2);
                $format = sprintf("%'.0{$d}d, ", $answer);
                $result .= mb_strtoupper($n) . '<sub>'.$from_ci.'</sub> = ' . $format;
            }
            if ($to_ci != 2) {
                $answer = base_convert($number, $from_ci, 2);
                $result .= $this->wrapScaleNumber($number, $from_ci).' = '.$this->wrapScaleNumber($answer, 2);
                $result .= '<br>';
                $d = $this->getCountBinaryDigit($to_ci);
                $number_array = array_chunk(str_split($answer), $d);
                $answer = base_convert($number, $from_ci, $to_ci);
                foreach ($number_array as $k => $n) {
                    $format = sprintf("%'.0{$d}d = {$answer[$k]}, ", implode($n), );
                    $result .= $format;
                }
            }
            return $result;
        }
    }

    public function getCountBinaryDigit($from_ci) {
        switch ($from_ci) {
            case 8:
                $d = 3;
                break;
            case 16:
                $d = 4;
                break;
            case 4:
            default:
                $d = 2;
                break;
        }
        return $d;
    }
}