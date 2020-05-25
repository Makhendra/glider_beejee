<?php

namespace App\Http\Controllers;

use App\Models\UserTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LkController extends Controller
{
    public function index($title = 'Личный кабинет')
    {
        $user = Auth::user();
        $userTasks = UserTask::whereUserId($user->id)
            ->with('group')
            ->get();
        $progress = [];
        foreach ($userTasks as $userTask) {
            $groupName = $userTask->group->name;
            $progress[$groupName]['all'] = isset($progress[$groupName]['all']) ? $progress[$groupName]['all'] + 1 : 1;
            $hintUse = $userTask->hint_use;
            if($userTask->status == UserTask::SUCCESS or ($userTask->status == UserTask::NEXT && ! $hintUse)) {
                $progress[$groupName]['success'] = isset($progress[$groupName]['success']) ? $progress[$groupName]['success'] + 1 : 1;
            } elseif ($userTask->status != UserTask::INIT) {
                $progress[$groupName]['wrong'] = isset($progress[$groupName]['wrong']) ? $progress[$groupName]['wrong'] + 1 : 1;
            }
        }
        foreach ($progress as &$p) {
            $all = $p['all'];
            $p['all'] = round( (($all - $p['success'] - $p['wrong']) / $all) * 100, 2);
            $p['success'] = round(($p['success'] / $all) * 100, 2);
            $p['wrong'] = round(($p['wrong'] / $all) * 100, 2);
        }
        return view('lk', compact('title', 'user', 'progress'));
    }
}
