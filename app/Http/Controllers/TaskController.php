<?php

namespace App\Http\Controllers;


use App\Models\GroupTask;
use App\Models\Task;
use App\Models\UserTask;
use App\Tasks\TaskCreator;
use App\Tasks\TaskInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskController extends Controller
{

    /**
     * Показывает все задачи определенной группы
     * @param $group_id
     * @param string $title
     * @return array|Factory|View|mixed
     */
    public function index($group_id)
    {
        $activeGroup = GroupTask::with('seo')->find($group_id);
        if ($activeGroup) {
            $title = $activeGroup->name;
            $groups = GroupTask::active()->get();
            $tasks = Task::with(['userTask', 'seo'])
                ->whereGroupId($group_id)->active()->get();
            return view('tasks.index', compact('group_id', 'groups', 'tasks', 'title', 'activeGroup'));
        }
        abort(404);
    }

    /**
     * Показывает сгенерированную задачу для пользователя
     * @param $id
     * @return array|Factory|View|mixed
     */
    public function show($id)
    {
        $task = Task::with(['group', 'seo'])->find($id);
        $taskCreator = (new TaskCreator($task))->getTask();
        $this->getUserTask($taskCreator, $task->id, $task->group_id);
        $taskCreator->setUserTask($task->task_text);
        return view($taskCreator->getView(), $taskCreator->getData());
    }

    /**
     * Отдает следующую задачу
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function nextTask(Request $request, $id)
    {
        $success = $request->get('success', 0);
        $task = Task::find($id);
        $user_task = UserTask::NextTaskByUser($task->id, Auth::id())->first();

        if ($success) {
            $user_task->status = UserTask::SOLVED;
        } else {
            $user_task->hint_use = 1;
        }

        $user_task->save();
        return redirect()->route('tasks.show', $task->id);
    }

    /**
     * Отдает или генерирует задачу
     * @param TaskInterface $creator
     * @param $task_id
     * @param $group_id
     * @return UserTask|Builder|Model|object|null
     */
    public function getUserTask(TaskInterface $creator, $task_id, $group_id)
    {
        $user_id = Auth::id();
        $user_task = UserTask::NextTaskByUser($task_id, $user_id)->first();
        if (empty($user_task)) {
            $data = $creator->initData();
            $user_task = UserTask::create(compact('task_id', 'user_id', 'group_id', 'data'));
        } else {
            $creator->setData($user_task->data);
        }
        return $user_task;
    }

    /**
     * Проверка верный ли ответ
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function checkAnswer(Request $request, $id)
    {
        $task = Task::find($id);
        $taskCreator = (new TaskCreator($task))->getTask();
        $this->getUserTask($taskCreator, $task->id, $task->group_id);
        return $taskCreator->checkAnswer($request);
    }
}
