<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Royalty extends Model
{
    protected $guarded = [];
    protected $dates = [
        'earned_at',
    ];
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
