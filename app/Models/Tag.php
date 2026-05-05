<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'tag_track');
    }
}
