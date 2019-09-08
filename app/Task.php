<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const NOT_FOUND = 404;

    public static function findBySlug($slug)
    {
        $model = self::whereSlug($slug)->first();
        if($model){
            return $model;
        }
        abort(self::NOT_FOUND);
    }
}
