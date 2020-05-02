<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Error
 *
 * @property int $id
 * @property string $name
 * @property string|null $desc
 * @method static Builder|Error newModelQuery()
 * @method static Builder|Error newQuery()
 * @method static Builder|Error query()
 * @method static Builder|Error whereDesc($value)
 * @method static Builder|Error whereId($value)
 * @method static Builder|Error whereName($value)
 * @mixin Eloquent
 */
class Error extends Model
{
    public $table = 'errors';
    public $timestamps = false;
    public $fillable = ['name', 'desc'];
}
