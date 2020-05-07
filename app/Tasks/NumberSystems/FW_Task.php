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

    public function getView()
    {
        return 'tasks.show_templates.FW_Task';
    }

    public function initData()
    {
        $count_chars = (int)rand(3, 5);
        $count_letters = (int)rand(3, $count_chars);
        $letters = $this->generateList($count_letters);
        $list = $this->generateListWordLetters($letters, $count_letters, $count_chars);
        $number_letter = rand(1, $count_chars - 1);
        $letter = $letters[$number_letter];
        $this->data = compact('count_letters', 'count_chars', 'letters', 'letter', 'list', 'number_letter');
        return $this->data;
    }

    public function replaceText()
    {
        $this->userTask = str_replace('{count_letters}', $this->data['count_letters'], $this->userTask);
        $this->userTask = str_replace('{count_chars}', $this->data['count_chars'], $this->userTask);
        $letters = implode(', ', $this->data['letters']);
        $list = array_map(
            function ($item, $key) {
                return $key . '. ' . $item;
            },
            $this->data['list'],
            range(1, count($this->data['list']))
        );
        $list = implode(',<br> ', $list);
        $this->userTask = str_replace('{letters}', $letters, $this->userTask);
        $this->userTask = str_replace('{letter}', $this->data['letter'], $this->userTask);
        $this->userTask = str_replace('{list}', $list, $this->userTask);
    }

    public function validateRules()
    {
        return [
            'answer' => 'required|integer',
            'count_chars' => 'required|integer',
            'count_letters' => 'required|integer',
            'all_count_word' => 'required|integer',
        ];
    }

    public function checkAnswer(Request $request)
    {
        $request->validate($this->validateRules());
        $data = $request->all();
        $answer = ($data['all_count_word'] / $data['count_chars']) * ($data['count_letters'] - 1) + 1;
        if ($request->get('answer') == $answer) {
            return success();
        } else {
            return fail();
        }
    }

}
