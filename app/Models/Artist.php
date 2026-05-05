<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function events()
    {
        return $this->hasMany(Event::class)->orderBy('event_date', 'desc');
    }
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    public function cases()
    {
        return $this->hasMany(Cases::class);
    }
    public function casesCount()
    {
        return $this->hasMany(Cases::class)->where('status', 'open');
    }
    public function royalties()
    {
        return $this->hasMany(Royalty::class);
    }
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }
	
	public function likes()
    {
        return $this->hasMany(LikedArtist::class, 'artist_id');
    }
}
