<?php

namespace App\Http\Controllers\artist;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        // dd($artist = Artist::all());
        $artist = auth()->user()->artist;

        // Check if artist is not null before fetching related data
        $tracks = $artist?->tracks()?->where('approved', true)->latest()->take(5)->get() ?? collect();
        $events = $artist?->events()?->latest()->take(5)->get() ?? collect();

        return view('artist.dashboard', compact('artist', 'tracks', 'events'));
    }
    public function getArtistTracks($artistId)
    {
        $artist = Artist::with('tracks.artist.user')->findOrFail($artistId);
        return response()->json(['tracks' => $artist->tracks]);
    }

}
