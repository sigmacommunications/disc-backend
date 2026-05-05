<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportResponse extends Model
{
    protected $guarded = [];
    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
