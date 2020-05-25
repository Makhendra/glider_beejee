<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CustomSession
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Error newModelQuery()
 * @method static Builder|Error newQuery()
 * @method static Builder|Error query()
 * @method static Builder|Error whereId($value)
 * @method static Builder|Error getId($value)
 * @method static Builder|Error getEmail($value)
 * @method static Builder|Error getName($value)
 * @mixin Eloquent
 */
class SocialAccount extends Model
{
    protected $table = 'social_accounts';
    protected $guarded = [];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class);
    }
}