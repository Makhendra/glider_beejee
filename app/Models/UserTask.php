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
 * @property int $type_error
 * @property string $user_answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
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
 * @method static Builder|UserTask whereUserAnswer($value)
 * @method static create(array $array)
 * @mixin Eloquent
 */
class UserTask extends Model
{
    protected $guarded = [];
    protected $appends = ['success'];

    const INIT = 0;
    const SUCCESS = 1;
    const WRONG = 2;
    const NEXT = 3;

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
        return $query->where('status', '!=', self::NEXT);
    }

    public function scopeNextTaskByUser(Builder $query, $task_id, $user_id)
    {
        return $query->where(compact('task_id', 'user_id'))->NotSolved();
    }

    public function group() {
        return $this->belongsTo(GroupTask::class, 'group_id', 'id');
    }

}
