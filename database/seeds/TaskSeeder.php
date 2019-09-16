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
                'task_text' => "Сколько целых чисел x, для которых выполняется неравнество <b>{number1}<sub>{scale_of_notation1}</sub> < x < {number2}<sub>{scale_of_notation2}</sub></b> ?",
                'interface' => 'CE_Task'
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
