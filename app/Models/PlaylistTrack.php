<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistTrack extends Model
{
    protected $table = 'playlist_track';
    protected $fillable = [
        'playlist_id',
        'track_id',
    ];
}
