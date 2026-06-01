<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Track extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($track) {
            do {
                $randomDigits = Str::random(10);
                // Ensure it's only digits
                $randomDigits = preg_replace('/[^0-9]/', '', $randomDigits);
                // Pad with zeros if needed to make exactly 10 digits
                $randomDigits = str_pad(substr($randomDigits, 0, 10), 10, '0', STR_PAD_RIGHT);
                $track->track_no = 'DM-' . $randomDigits;
            } while (self::where('track_no', $track->track_no)->exists());
        });
    }
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
    // public function user()
    // {
    //     return $this->hasOneThrough(User::class, Artist::class);
    // }
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_track');
    }
	public function playlistTracks()
	{
		return $this->hasMany(PlaylistTrack::class);
	}
    public function getIsLikedAttribute()
    {
        if (!Auth::check()) {
            return false; // If no user is logged in, return false
        }

        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    // Relationship to LikedSong
    public function likes()
    {
        return $this->hasMany(LikedSong::class, 'track_id');
    }
    public function plays()
    {
        return $this->hasMany(SongPlay::class, 'track_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_track');
    }
    
    // Append the custom attribute to the model
    protected $appends = ['is_liked','audio_file','cover_image'];

    public function getAudioFileAttribute()
    {
        return [$this->audio_file_path,$this->cover_image_path];
    }

    public function getCoverImageAttribute()
    {
        return $this->cover_image_path;
    }
}
