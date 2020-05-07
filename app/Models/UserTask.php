<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserTask
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property int $status
 * @property int $hint_use
 * @property mixed|null $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $type_error
 * @method static Builder|UserTask newModelQuery()
 * @method static Builder|UserTask newQuery()
 * @method static Builder|UserTask nextTaskByUser($task_id, $user_id)
 * @method static Builder|UserTask notSolved()
 * @method static Builder|UserTask query()
 * @method static Builder|UserTask whereCreatedAt($value)
 * @method static Builder|UserTask whereData($value)
 * @method static Builder|UserTask whereHintUse($value)
 * @method static Builder|UserTask whereId($value)
 * @method static Builder|UserTask whereStatus($value)
 * @method static Builder|UserTask whereTaskId($value)
 * @method static Builder|UserTask whereTypeError($value)
 * @method static Builder|UserTask whereUpdatedAt($value)
 * @method static Builder|UserTask whereUserId($value)
 * @method static create(array $array)
 * @mixin Eloquent
 */
class UserTask extends Model
{
    protected $guarded = [];

    const NOT_SOLVED = 0;
    const SOLVED = 1;

    protected $casts = [
        'data' => 'json'
    ];


    /**
     * Scope a query to only include active users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeNotSolved($query)
    {
        return $query->where(['status' => self::NOT_SOLVED, 'hint_use' => 0]);
    }

    public function scopeNextTaskByUser(Builder $query, $task_id, $user_id)
    {
        return $query->where(compact('task_id', 'user_id'))->NotSolved();
    }
}
