<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LikedArtist;
use App\Models\LikedEvent;
use App\Models\Artist;
use App\Models\Event;
use App\Models\User;
use App\Models\Track;
use App\Models\LikedSong;
use Validator;
use Auth;

class LikedController extends Controller
{
	
	public function getLikedArtist()
    {
        $user = Auth::user();

        // Fetch liked songs with necessary relationships
        $likedArtist = Artist::with(['user'])
            ->whereHas('likes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return response()->json(['message' => 'Artist liked List','artist_list' =>$likedArtist], 201);
		
    }
	
	public function getLikedEvent()
    {
        $user = Auth::user();

        // Fetch liked songs with necessary relationships
        $likedEvent = Event::with(['artist.user'])
            ->whereHas('likes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return response()->json(['message' => 'Event liked List','event_list' =>$likedEvent], 201);
		
    }
	
	public function getLikedTrack()
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
	
    public function artist_like_store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'artist_id' => 'required|array|min:1',
			'artist_id.*' => 'required|string|exists:artists,id',
		]);

		if($validator->fails())
		{
			return response()->json(['success'=>false,'message'=> $validator->errors()->first()],500);
		}

		$userId = Auth::id();
		$artistIds = $request->artist_id;

		// Get already liked artists to avoid duplicates
		$existingLikes = LikedArtist::where('user_id', $userId)
			->whereIn('artist_id', $artistIds)
			->pluck('artist_id')
			->toArray();

		// Filter out already liked artists
		$newArtistIds = array_diff($artistIds, $existingLikes);

		if(!empty($newArtistIds)) {
			// Prepare bulk insert data
			$likedArtistsData = array_map(function($artistId) use ($userId) {
				return [
					'user_id' => $userId,
					'artist_id' => $artistId,
					'created_at' => now(),
					'updated_at' => now(),
				];
			}, $newArtistIds);

			// Bulk insert
			LikedArtist::insert($likedArtistsData);
		}

		return response()->json([
			'message' => count($newArtistIds) . ' artist(s) liked successfully',
			'liked_artists' => $newArtistIds,
			'already_liked' => $existingLikes
		], 201);
	}
	
	public function event_like_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|string|exists:events,id', // Ensure track ID exists in tracks table
        ]);
		
		if($validator->fails())
		{
			return response()->json(['success'=>false,'message'=> $validator->errors()->first()],500);
		}
        // dd($request->all());
        $userId = Auth::id(); // Get authenticated user ID

        LikedEvent::firstOrCreate(
            [
                'user_id' => $userId,
                'event_id' => $request->event_id,
            ]
        );


        return response()->json(['message' => 'Event liked successfully'], 201);
    }
	
	public function track_like_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'track_id' => 'required|string|exists:tracks,id', // Ensure track ID exists in tracks table
        ]);
        // dd($request->all());
		if($validator->fails())
		{
			return response()->json(['success'=>false,'message'=> $validator->errors()->first()],500);
		}
        $userId = Auth::id(); // Get authenticated user ID

        LikedSong::firstOrCreate(
            [
                'user_id' => $userId,
                'track_id' => $request->track_id,
            ]
        );


        return response()->json(['message' => 'Track liked successfully'], 201);
    }
	
	public function artist_like_destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_id' => 'required|string|exists:artists,id', // Ensure track ID exists in tracks table
        ]);
		
		if($validator->fails())
		{
			return response()->json(['success'=>false,'message'=> $validator->errors()->first()],500);
		}

        $userId = Auth::id(); // Get authenticated user ID

        LikedArtist::where('user_id', $userId)
            ->where('artist_id', $request->artist_id)
            ->delete();

        return response()->json(['message' => 'Artist unliked successfully'], 200);
    }
	
	public function event_like_destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|string|exists:events,id', // Ensure track ID exists in tracks table
        ]);
		
		if($validator->fails())
		{
			return response()->json(['success'=>false,'message'=> $validator->errors()->first()],500);
		}

        $userId = Auth::id(); // Get authenticated user ID

        LikedEvent::where('user_id', $userId)
            ->where('event_id', $request->event_id)
            ->delete();
        
        $user = User::with(['liked_artist','subscriptions' => function($query) {
				$query->where('stripe_status', 'active');
			}])->find($userId);

        return response()->json(['message' => 'Event unliked successfully','user_info'=>$user], 200);
    }
	
	public function track_like_destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'track_id' => 'required|string|exists:liked_songs,track_id', // Ensure track ID exists in liked songs
        ]);
		
		if($validator->fails())
		{
			return response()->json(['success'=>false,'message'=> $validator->errors()->first()],500);
		}

        $userId = Auth::id(); // Get authenticated user ID

        LikedSong::where('user_id', $userId)
            ->where('track_id', $request->track_id)
            ->delete();

        return response()->json(['message' => 'Track unliked successfully'], 200);
    }
}
