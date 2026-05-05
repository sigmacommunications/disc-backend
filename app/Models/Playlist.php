<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $guarded = [];
    // In Playlist.php model
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_track');
    }

}
