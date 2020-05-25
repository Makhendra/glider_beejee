<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\CustomSession
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Error newModelQuery()
 * @method static Builder|Error newQuery()
 * @method static Builder|Error query()
 * @method static Builder|Error whereId($value)
 * @method static Builder|Error whereKey($value)
 * @method static Builder|Error whereValue($value)
 * @mixin Eloquent
 */
class CustomSession extends Model
{
    protected $table = 'custom_sessions';
    protected $guarded = [];
    protected $casts = ['value' => 'json'];

    public static function getValue($key) {
        return CustomSession::where('key', '=', $key)->latest()->first()->value ?? null;
    }

    public static function setValue($key, $value) {
        $user_id = Auth::id();
        CustomSession::create(compact('user_id', 'key', 'value'));
    }
}
