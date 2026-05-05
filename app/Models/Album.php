<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = [];
    protected function casts(): array
    {
        return [
            'release_date' => 'datetime',
        ];
    }
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}
