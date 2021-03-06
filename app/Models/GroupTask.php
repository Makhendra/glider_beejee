<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\GroupTask
 *
 * @property int $id
 * @property string $name
 * @property boolean $active
 * @property integer $sort
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|GroupTask newModelQuery()
 * @method static Builder|GroupTask newQuery()
 * @method static Builder|GroupTask query()
 * @method static Builder|GroupTask whereCreatedAt($value)
 * @method static Builder|GroupTask whereId($value)
 * @method static Builder|GroupTask whereName($value)
 * @method static Builder|GroupTask whereActive($value)
 * @method static Builder|GroupTask whereSort($value)
 * @method static Builder|GroupTask whereUpdatedAt($value)
 * @method static Builder|GroupTask active()
 * @method static truncate()
 * @method static create(array $array)
 * @mixin Eloquent
 */
class GroupTask extends Model
{
    protected $table = 'groups';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('active', 'desc')->orderBy('sort', 'asc');
        });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query)  {
        return $query->where('active', 1);
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'group_id', 'id');
    }

    public function seo() {
        return $this->morphOne(Seo::class, 'source', 'source');
    }
}
