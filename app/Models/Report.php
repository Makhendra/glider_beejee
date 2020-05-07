<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Report
 *
 * @property int $id
 * @property string $email
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Report newModelQuery()
 * @method static Builder|Report newQuery()
 * @method static Builder|Report query()
 * @method static Builder|Report whereCreatedAt($value)
 * @method static Builder|Report whereEmail($value)
 * @method static Builder|Report whereId($value)
 * @method static Builder|Report whereMessage($value)
 * @method static Builder|Report whereUpdatedAt($value)
 * @method static create(array $compact)
 * @mixin Eloquent
 */
class Report extends Model
{
    protected $fillable = ['email', 'message'];
}
