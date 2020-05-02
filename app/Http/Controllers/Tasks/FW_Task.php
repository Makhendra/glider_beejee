<?php


namespace App\Http\Controllers\Tasks;


use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;

// Все 4-буквенные слова, составленные из букв Д, Е, К, О, Р, записаны в алфавитном порядке и пронумерованы, начиная с 1.
// Ниже приведено начало списка. 1. ДДДД 2. ДДДЕ 3. ДДДК 4. ДДДО 5. ДДДР 6. ДДЕД ...
// Под каким номером в списке идёт первое слово, которое начинается с буквы K?
class FW_Task implements InterfaceTask
{

    public $title = 'Тренажер';
    public $to_ci = 10;
    public $task_text;
    public $slug;
    public $count_letters;
    public $letters = [];
    public $letter;
    public $number_letter;
    public $list = [];

    public function __construct($task, $user_task)
    {
        $data = json_decode($user_task->data, true);
        $this->count_letters = $data['count_letters'];
        $this->letters = $data['letters'];
        $this->letter = $data['letter'];
        $this->list = $data['list'];
        $this->number_letter = $data['number_letter'];
        $this->task_text = $this->replaceText($task->task_text);
        $this->slug = $this->replaceText($task->slug);
    }

    public function generate()
    {
        $data = get_object_vars($this);
        return $data;
    }

    public function answer()
    {
        $number = str_pad($this->number_letter, $this->count_letters, '0', STR_PAD_RIGHT);
        return base_convert($number, $this->count_letters, $this->to_ci) + 1;
    }

    public function solution()
    {
        // TODO: Implement solution() method.
    }

    public function replaceText($text)
    {
        $text = str_replace('{count_letters}', $this->count_letters, $text);
        $letters = implode(', ', $this->letters);
        $list = array_map(function ($item, $key) {
            return $key . '. ' . $item;
        }, $this->list, range(1, count($this->list)));
        $list = implode(',<br> ', $list);
        $text = str_replace('{letters}', $letters, $text);
        $text = str_replace('{letter}', $this->letter, $text);
        $text = str_replace('{list}', $list, $text);
        return $text;
    }

    public static function getData()
    {
        $alpha = getAlpha();

        $count_letters = (int)rand(3, 5);

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

        $number_letter = rand(1, $count_letters - 1);
        $letter = $letters[$number_letter];

        $list = [];
        $w = 0;
        for ($i = 0; $i < $count_letters + 1; $i++) {
            $word = str_pad(base_convert($w, 10, $count_letters), $count_letters, '0', STR_PAD_LEFT);
            foreach ($letters as $digit => $character) {
                $word = str_replace($digit, $character, $word);
            }
            $w += 1;
            $list[] = $word;
        }
        return compact('count_letters', 'letters', 'letter', 'list', 'number_letter');
    }

    public function check_answer(Request $request)
    {
        $request->validate([
            'answer' => 'required|integer',
        ]);
        $data = $request->all();
        $answer = $this->answer();
        if ($data['answer'] == $answer) {
            return (new TaskController)->success();
        } else {
            return (new TaskController)->fail();
        }
        return (new TaskController)->fail();
    }

}
