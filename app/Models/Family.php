<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Report
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @method static Builder|Report newModelQuery()
 * @method static Builder|Report newQuery()
 * @method static Builder|Report query()
 * @method static Builder|Report whereId($value)
 * @method static Builder|Report whereKey($value)
 * @method static Builder|Report whereValue($value)
 * @method static create(array $compact)
 * @mixin Eloquent
 */
class Family extends Model
{
    protected $table = 'family';
    public $timestamps = false;
    protected $guarded = [];

    const WOMEN_GENDER = 1;
    const MEN_GENDER = 0;
}
