<?php


namespace App\Http\Controllers;


use App\Models\GroupTask;

class GroupsController extends Controller
{
    public function index($title = 'Типы заданий')
    {
        $groups = GroupTask::with('seo')->active()->get();
        return view('groups.index', compact('groups', 'title'));
    }
}