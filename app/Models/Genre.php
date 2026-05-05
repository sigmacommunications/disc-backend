<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [];
    
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}
