<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class LkController extends Controller
{
    public function index($title = 'Личный кабинет')
    {
        $user = Auth::user();
        return view('lk', compact('title', 'user'));
    }
}
