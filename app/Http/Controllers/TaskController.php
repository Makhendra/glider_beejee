<?php

namespace App\Http\Controllers;


use App\Task;
use App\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index($title = 'Задачи')
    {
        $tasks = Task::with('userTask')->get();
        return view('tasks.index', compact('tasks', 'title'));
    }

    public function show($id)
    {
        $task = Task::find($id);
        return $this->getTask($task);
    }

    public function nextTask(Request $request, $slug)
    {
        $success = $request->get('success', 0);
        $task = Task::findBySlug($slug);
        $user_task = UserTask::NextTaskByUser($task->id, Auth::id())->first();

        if($success){
            $user_task->status =  UserTask::SOLVED;
        } else {
            $user_task->hint_use =  1;
        }

        $user_task->save();
        return redirect()->route('tasks.show', $task->id);
    }

    public function getUserTask($class, $id)
    {
        $user_task = UserTask::NextTaskByUser($id, Auth::id())->first();

        if (empty($user_task)) {
            $user_task = UserTask::create([
                'task_id' => $id,
                'user_id' => Auth::id(),
                'data' => json_encode(
                    $class::getData()
                )
            ]);
        }
        return $user_task;
    }

    public function getTask($task)
    {
        $class = "App\Http\Controllers\Tasks\\$task->interface";
        $user_task = $this->getUserTask($class, $task->id);
        $data = (new $class($task, $user_task))->generate();
        return view('tasks.show', compact('data'));
    }

    public function check_answer(Request $request, $slug)
    {
        $task = Task::findBySlug($slug);
        $class = "App\Http\Controllers\Tasks\\$task->interface";
        $user_task = $this->getUserTask($class, $task->id);
        return (new $class($task, $user_task))->check_answer($request);
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
