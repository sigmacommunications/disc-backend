<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongPlay extends Model
{
    use HasFactory;
    protected $guarded = [];
	
	public function track()
    {
        return $this->hasOne(Track::class,'id','track_id');
    }
	
	public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
