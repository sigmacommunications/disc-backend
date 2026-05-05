<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];
    protected function casts(): array
    {
        return [
            'event_date' => 'datetime',
        ];
    }
	
	public function artist()
    {
        return $this->hasOne(Artist::class,'id','artist_id');
    }
	
	public function likes()
    {
        return $this->hasMany(LikedEvent::class, 'event_id');
    }
}
