<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Playlist;
use Auth;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function getPlaylistTracks($playlistId)
    {
        $playlist = Playlist::with('tracks.artist.user')->findOrFail($playlistId);
        return response()->json(['tracks' => $playlist->tracks]);
    }
    public function index()
    {
        $playlists = Auth::user()->playlists;
        return view('playlists.index', compact('playlists'));
    }

    // Show a single playlist and its tracks
    public function show(Playlist $playlist)
    {
        $playlist->load(['tracks.artist.user']);
        return view('playlists.show', compact('playlist'));
    }

    // Create a new playlist
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $playlist = Auth::user()->playlists()->create($request->only('name', 'description'));
        return redirect()->back()->with('success', 'Playlist created successfully.');
    }

    // Add a song to a playlist
    public function addTrack(Request $request, Playlist $playlist)
    {

        $request->validate([
            'track_id' => 'required|exists:tracks,id',
        ]);

        $playlist->tracks()->syncWithoutDetaching($request->track_id);
        return redirect()->back()->with('success', 'Track added to playlist.');
    }
}
