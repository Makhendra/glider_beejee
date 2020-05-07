<?php

use App\Models\Task;
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
                'title' => 'Сколько целых чисел x, для которых выполняется неравнество ...?',
                'task_text' => "Сколько целых чисел x, для которых выполняется неравнество <b>{number1}<sub>{scale_of_notation1}</sub>&nbsp;<&nbsp;x&nbsp;<&nbsp;{number2}<sub>{scale_of_notation2}</sub></b>&nbsp;?",
                'type' => '1',
                'group_id' => 1,
            ],
            [
                'title' => 'Под каким номером в списке идёт первое слово, которое начинается с буквы А?',
                'task_text' => "Все {count_letters}-буквенные слова, составленные из букв {letters}, записаны в алфавитном порядке и пронумерованы, начиная с 1.Ниже приведено начало списка. <br> {list} <br>Под каким номером в списке идёт первое слово, которое начинается с буквы {letter}?",
                'type' => '2',
                'group_id' => 1,
            ],
            [
                'title' => 'Какова протяженность дороги от пункта А до пункта Б?',
                'task_text' => 'На рисунке снизу схема дорог в виде графа, в таблице содержатся сведения о протяженности каждой из этих дорог(в&nbsp;киллиметрах). 
                Так как таблицу и схему рисовали независимо друг от друга, то нумерация населенных пунктов в таблице никак не связана с обозначениями. Какова протяженность дороги от {start} до {end}?
                {graph}{table}',
                'type' => 3,
                'group_id' => 2,
            ]
        ];

        foreach ($tasks as $task){
            Task::create($task);
        }
    }
}
