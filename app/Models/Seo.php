<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seo';
    protected $guarded = [];

    /**
     * Get the owning imageable model.
     */
    public function seoMorph()
    {
        return $this->morphTo();
    }
}
