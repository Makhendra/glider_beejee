<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property string $title
 * @property string $type
 * @property string|null $task_text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $group_id
 * @property-read Collection|UserTask[] $userTask
 * @property-read int|null $user_task_count
 * @method static Builder|Task newModelQuery()
 * @method static Builder|Task newQuery()
 * @method static Builder|Task query()
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereGroupId($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereType($value)
 * @method static Builder|Task whereTaskText($value)
 * @method static Builder|Task whereTitle($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @method static find($id)
 * @mixin Eloquent
 */
class Task extends Model
{
    protected $guarded = [];
    const NOT_FOUND = 404;

    public static function findBySlug($slug)
    {
        $model = self::whereSlug($slug)->first();
        if($model){
            return $model;
        }
        abort(self::NOT_FOUND);
        return $model;
    }

    public function userTask(){
        return $this->hasMany(UserTask::class);
    }

    public function successUserTask(){
        return $this->hasMany(UserTask::class)
            ->whereIN('status', [UserTask::SUCCESS, UserTask::NEXT])
            ->where('hint_use', '=', 0)
            ->where('user_id', Auth::id())
            ->select('id');
    }

    public function group() {
        return $this->belongsTo(GroupTask::class);
    }

    public function scopeActive(Builder $query)  {
        return $query->where('active', 1);
    }

    public function seo() {
        return $this->morphOne(Seo::class, 'source', 'source');
    }
}
