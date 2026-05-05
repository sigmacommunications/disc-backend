<?php

namespace App\Http\Controllers;

use App\Models\LikedSong;
use App\Models\Track;
use Auth;
use Illuminate\Http\Request;

class LikedSongController extends Controller
{
    public function getLikedSongs()
    {
        $user = Auth::user();

        // Fetch liked songs with necessary relationships
        $likedSongs = Track::with(['artist.user', 'album', 'genre'])
            ->whereHas('likes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return response()->json(['tracks' => $likedSongs]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trackId' => 'required|string|exists:tracks,id', // Ensure track ID exists in tracks table
        ]);
        // dd($request->all());
        $userId = Auth::id(); // Get authenticated user ID

        LikedSong::firstOrCreate(
            [
                'user_id' => $userId,
                'track_id' => $validated['trackId'],
            ]
        );


        return response()->json(['message' => 'Song liked successfully'], 201);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'trackId' => 'required|string|exists:liked_songs,track_id', // Ensure track ID exists in liked songs
        ]);

        $userId = Auth::id(); // Get authenticated user ID

        LikedSong::where('user_id', $userId)
            ->where('track_id', $validated['trackId'])
            ->delete();

        return response()->json(['message' => 'Song unliked successfully'], 200);
    }

}
