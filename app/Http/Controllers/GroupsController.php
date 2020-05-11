<?php


namespace App\Http\Controllers;


use App\Models\GroupTask;

class GroupsController extends Controller
{
    public function index($title = 'Группы')
    {
        $groups = GroupTask::active()->get();
        return view('groups.index', compact('groups', 'title'));
    }
}