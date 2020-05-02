<?php


namespace App\Http\Controllers;


use App\GroupTask;

class GroupsController extends Controller
{
    public function index($title = 'Группы')
    {
        $groups = GroupTask::all();
        return view('groups.index', compact('groups', 'title'));
    }
}