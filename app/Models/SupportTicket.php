<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $guarded = [];
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function responses()
    {
        return $this->hasMany(SupportResponse::class);
    }
}
