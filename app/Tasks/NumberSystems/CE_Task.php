<?php


namespace App\Tasks\NumberSystems;


use App\Tasks\TaskInterface;
use App\Tasks\TaskTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Сколько существует целых чисел x, для которых выполняется неравенство 2A16<x<618?
class CE_Task implements TaskInterface
{
    use TaskTrait, NumberSystemService;

    public function initData()
    {
        $scale_of_notation1 = (int)rand(2, 16);
        $scale_of_notation2 = (int)rand(2, 16);

        $number1 =  rand(0, 1000);
        $number2 =  rand($number1, 1000);
        $number1 =  base_convert($number1, $this->to_ci, $scale_of_notation1);
        $number2 =  base_convert($number2, $this->to_ci, $scale_of_notation2);

        $answer1 = base_convert($number1, $scale_of_notation1, $this->to_ci);
        $answer2 = base_convert($number2, $scale_of_notation2, $this->to_ci);

        $this->data = [
            'number1' => $number1,
            'number2' => $number2,
            'scale_of_notation1' => $scale_of_notation1,
            'scale_of_notation2' => $scale_of_notation2,
            'answer1' => $answer1,
            'answer2' => $answer2,
            'format1' => $this->formatNumber($number1, $scale_of_notation1, $this->to_ci, $answer1),
            'format2' => $this->formatNumber($number2, $scale_of_notation2, $this->to_ci, $answer2),
        ];
        return $this->data;
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

    public function getView()
    {
        return 'tasks.show_templates.CE_Task';
    }

    public function replaceText()
    {
        $replace = [
            '{number1}' => $this->data['number1'],
            '{number2}' => $this->data['number2'],
            '{scale_of_notation1}' => $this->data['scale_of_notation1'],
            '{scale_of_notation2}' => $this->data['scale_of_notation2'],
        ];
        foreach ($replace as $key => $value) {
            try {
                $this->userTask = str_replace($key, $value, $this->userTask);
            } catch (\Exception $exception) {
                Log::debug('CE_Task - replaceText');
                Log::debug($exception->getMessage());
            }
        }
    }

    public function validateRules()
    {
        return [
            'number1' => 'required',
            'number2' => 'required',
            'scale_of_notation1' => 'required|integer',
            'scale_of_notation2' => 'required|integer',
            'answer' => 'required|integer',
        ];
    }

    public function checkAnswer(Request $request)
    {
        $request->validate($this->validateRules());
        $data = $request->all();
        $answer1 = base_convert($data['number1'], $data['scale_of_notation1'], 10);
        $answer2 = base_convert($data['number2'], $data['scale_of_notation2'], 10);
        if ($data['answer'] == abs($answer2 - $answer1)) {
            return success();
        } else {
            return fail();
        }
    }
}
