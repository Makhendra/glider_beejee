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
     * @return array|Factory|View|mixed
     */
    public function index($group_id)
    {
        $activeGroup = GroupTask::with('seo')->find($group_id);
        if ($activeGroup) {
            $title = $activeGroup->name;
            $groups = GroupTask::active()->get();
            $tasks = Task::with(['userTask', 'seo', 'successUserTask'])
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
        $this->getUserTask($taskCreator);
        return view($taskCreator->getView(), $taskCreator->getData());
    }

    /**
     * Отдает следующую задачу
     * @param $id
     * @return RedirectResponse
     */
    public function nextTask($id)
    {
        $task = Task::find($id);
        $user_task = UserTask::NextTaskByUser($task->id, Auth::id())->first();
        $user_task->update(['status' => UserTask::NEXT]);
        return redirect()->route('tasks.show', $task->id);
    }

    /**
     * Отдает или генерирует задачу
     * @param TaskInterface $creator
     * @return UserTask|Builder|Model|object|null
     */
    public function getUserTask(TaskInterface $creator)
    {
        $userId = Auth::id();
        $userTask = UserTask::NextTaskByUser($creator->task->id, $userId)->first();
        if (empty($userTask)) {
            $data = $creator->initData();
            $userTask = UserTask::create(
                [
                    'task_id' => $creator->task->id,
                    'user_id' => $userId,
                    'group_id' => $creator->task->group_id,
                    'data' => $data
                ]
            );
        } else {
            $creator->setData($userTask->data);
        }
        $creator->setTextUserTask($creator->task->task_text);
        $creator->setUserTask($userTask);
        $creator->setFormatAnswer();
        return $userTask;
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
        $this->getUserTask($taskCreator);
        $taskCreator->setSuccess($taskCreator->checkAnswer($request));
        return redirect()->route('tasks.show', $task->id);
    }

    public function getSolution($id)
    {
        $user_task = UserTask::NextTaskByUser($id, Auth::id())->first();
        $user_task->update(['hint_use' => 1]);
        return redirect()->route('tasks.show', $id);
    }
}
