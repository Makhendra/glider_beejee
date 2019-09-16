<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    protected $guarded = [];

    const NOT_SOLVED = 0;
    const SOLVED = 1;
    const GET_HINT = 2;
}
