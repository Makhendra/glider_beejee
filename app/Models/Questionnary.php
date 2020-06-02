<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnary extends Model
{
    protected $table = 'questionnaries';
    protected $guarded = [];
    protected $casts = ['data' => 'array'];
}
