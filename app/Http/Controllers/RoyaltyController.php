<?php

namespace App\Http\Controllers;

use App\Models\Track;
use DB;
use Illuminate\Http\Request;

class RoyaltyController extends Controller
{
    public function index()
    {
        // Get all tracks with their artists
        $tracks = Track::where('approved', 1)->with(['artist.user:id,name', 'genre:id,name'])->withCount('plays')
            ->paginate(10); // Pagination (10 tracks per page)
        // dd($tracks->getCollection());
        // Map royalties for each track
        $tracks->getCollection()->transform(function ($track) {
            // Count the number of plays for the track
            // $actualPlayCount = DB::table('song_plays')
            //     ->where('track_id', $track->id)
            //     ->count();

            // // Calculate total royalty
            // $totalRoyalty = $track->play_count > 0
            //     ? ($actualPlayCount / $track->play_count) * $track->royalty_amount
            //     : 0;
            $totalRoyalty = $track->play_count > 0
                ? ($track->plays_count / $track->play_count) * $track->royalty_amount
                : 0;

            // Add royalty data to the track
            $track->actual_play_count = $track->plays_count;
            $track->total_royalty = round($totalRoyalty, 2); // Round to 2 decimals
            return $track;
        });

        return view('admin.royalties.index', compact('tracks'));
    }
}
