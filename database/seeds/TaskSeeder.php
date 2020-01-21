<?php

use App\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = [
            [
                'task_text' => "Сколько целых чисел x, для которых выполняется неравнество <b>{number1}<sub>{scale_of_notation1}</sub>&nbsp;<&nbsp;x&nbsp;<&nbsp;{number2}<sub>{scale_of_notation2}</sub></b>&nbsp;?",
                'interface' => 'CE_Task'
            ],
            [
                'task_text' => "Все {count_letters}-буквенные слова, составленные из букв {letters}, записаны в алфавитном порядке и пронумерованы, начиная с 1.
Ниже приведено начало списка. <br> {list} <br>
Под каким номером в списке идёт первое слово, которое начинается с буквы {letter}?",
                'interface' => 'FW_Task'
            ]
        ];

        foreach ($tasks as $task){
            Task::create([
                'task_text' => $task['task_text'],
                'interface' => $task['interface'],
                'title' => $task['interface'],
                'slug' => $task['interface'],
            ]);
        }
    }
}
