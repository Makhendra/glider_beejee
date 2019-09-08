<?php


namespace App\Http\Controllers\Tasks;


use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;

class CE_Task implements InterfaceTask
{
    public $number1;
    public $number2;
    public $scale_of_notation1;
    public $scale_of_notation2;
    public $answer1;
    public $answer2;
    public $title = 'Тренажер';
    public $to_ci = 10;
    public $task_text;
    public $slug;

    public function __construct($task)
    {
        $this->number1 = 7;
        $this->number2 = '7A';
        $this->scale_of_notation1 = 8;
        $this->scale_of_notation2 = 16;
        $this->answer1 = $this->answerNumber($this->number1, $this->scale_of_notation1, $this->to_ci);
        $this->answer2 = $this->answerNumber($this->number2, $this->scale_of_notation2, $this->to_ci);
        $this->task_text = $this->replaceText($task->task_text);
        $this->slug = $this->replaceText($task->slug);
    }

    /**
     * @return array
     */
    public function generate()
    {
        $data = get_object_vars($this);
        $data['format1'] = $this->formatNumber($this->number1, $this->scale_of_notation1, $this->to_ci, $this->answer1);
        $data['format2'] = $this->formatNumber($this->number2, $this->scale_of_notation2, $this->to_ci, $this->answer2);

        return $data;
    }

    public function answer()
    {
//        $answer1 = base_convert($this->number1, $this->scale_of_notation1, $this->to_ci);
//        $answer2 = base_convert($this->number2, $this->scale_of_notation2, $this->to_ci);
//        return $answer;
        return 100;
    }

    public function solution()
    {
        // TODO: Implement solution() method.
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
        return ['text' => $text, 'answer_format' => $answer."<sub>$to_ci</sub>", 'answer' => $answer];
    }

    public function replaceText($text)
    {
        $text = str_replace('{number1}', $this->number1, $text);
        $text = str_replace('{number2}', $this->number2, $text);

        $text = str_replace('{scale_of_notation1}', $this->scale_of_notation1, $text);
        $text = str_replace('{scale_of_notation2}', $this->scale_of_notation2, $text);
        return $text;
    }

    public function answerNumber($number, $scale_of_notation, $to_ci)
    {
        return base_convert($number, $scale_of_notation, $to_ci);
    }

    public function check_answer(Request $request)
    {
        $request->validate([
            'number1' => 'required',
            'number2' => 'required',
            'scale_of_notation1' => 'required|integer',
            'scale_of_notation2' => 'required|integer',
            'answer' => 'required|integer',
        ]);
        $data = $request->all();
        $answer1 = base_convert($data['number1'], $data['scale_of_notation1'], 10);
        $answer2 = base_convert($data['number2'], $data['scale_of_notation2'], 10);
        if ($data['answer'] == ($answer2 - $answer1)) {
            return (new TaskController)->success();
        } else {
            return (new TaskController)->fail();
        }
        return (new TaskController)->fail();
    }

}
