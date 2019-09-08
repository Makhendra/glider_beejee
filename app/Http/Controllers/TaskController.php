<?php

namespace App\Http\Controllers;


use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index($title = 'Задачи')
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks', 'title'));
    }
    //INSERT INTO `tasks` (`id`, `title`, `slug`, `interface`, `task_text`, `user_id`, `owner_id`, `created_at`, `updated_at`) VALUES (NULL, 'CE_Task', 'test', 'CE_Task', 'Сколько существует целых чисел x, для&nbsp;которых выполняется неравенство <br> <b> {number1}<sub>{scale_of_notation1}</sub> <&nbsp;x&nbsp;<&nbsp;{number2}<sub>{scale_of_notation2}</sub></b>?', '1', '1', NULL, NULL)

    public function show($id)
    {
        $task = Task::find($id);
        return $this->getTask($task);
    }

    public function next($slug)
    {

    }

    public function getTask($task)
    {
        $class = "App\Http\Controllers\Tasks\\$task->interface";
        $data = (new $class($task))->generate();
        return view('tasks.show', compact('data'));
    }

    public function check_answer(Request $request, $slug)
    {
        $task = Task::findBySlug($slug);
        $class = "App\Http\Controllers\Tasks\\$task->interface";
        return (new $class($task))->check_answer($request);
    }

    public function success()
    {
        return response()->json(['success' => true], 200);
    }

    public function fail()
    {
        return response()->json(['success' => false], 200);
    }
}
