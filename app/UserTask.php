<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    protected $guarded = [];

    const NOT_SOLVED = 0;
    const SOLVED = 1;


    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotSolved($query)
    {
        return $query->where(['status' => self::NOT_SOLVED, 'hint_use' => 0]);
    }

    public function scopeNextTaskByUser($query, $task_id, $user_id)
    {
        return $query->where(['task_id' => $task_id, 'user_id' => $user_id])->NotSolved();
    }
}
