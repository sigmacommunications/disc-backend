<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Track;
use App\Models\User;
use App\Models\SongPlay;
use App\Models\Playlist;
use App\Models\PlaylistTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RecommendationController extends Controller
{
    
	public function recommendedTracks(Request $request)
	{
		try 
		{
			$limit = $request->get('limit', 20);
			$timeRange = $request->get('time_range', 'all');
			$userId = auth()->id();

			// Using Eloquent to get user's playlists
			$userPlaylists = \App\Models\Playlist::where('user_id', $userId)->get();
			$userPlaylistIds = $userPlaylists->pluck('id')->toArray();

			// Get excluded track IDs using relationship
			$excludedTrackIds = \App\Models\PlaylistTrack::whereIn('playlist_id', $userPlaylistIds)
				->pluck('track_id')
				->unique()
				->toArray();

			$tracksQuery = Track::with('artist.user')
				->when(!empty($excludedTrackIds), function($query) use ($excludedTrackIds) {
					return $query->whereNotIn('id', $excludedTrackIds);
				});

			// Time range filter
			switch($timeRange) {
				case 'day':
					$tracksQuery->where('created_at', '>=', now()->subDay());
					break;
				case 'week':
					$tracksQuery->where('created_at', '>=', now()->subWeek());
					break;
				case 'month':
					$tracksQuery->where('created_at', '>=', now()->subMonth());
					break;
				case 'year':
					$tracksQuery->where('created_at', '>=', now()->subYear());
					break;
			}

			// Alternative: Direct subquery to exclude tracks
			$tracksQuery->whereNotIn('id', function($query) use ($userId) {
				$query->select('track_id')
					->from('playlist_track')
					->whereIn('playlist_id', function($q) use ($userId) {
						$q->select('id')
							->from('playlists')
							->where('user_id', $userId);
					});
			});

			// Calculate trending score
			$tracks = $tracksQuery->get()->map(function($track) {
				$trendingScore = ($track->plays_count * 0.6) + ($track->likes_count * 0.4);

				if ($track->last_played_at && $track->last_played_at >= now()->subDay()) {
					$trendingScore *= 1.2;
				}
				
				$albumData = null;
				if ($track->album) {
					$albumData = [
						'id' => $track->album->id,
						'title' => $track->album->title,
						'slug' => $track->album->slug ?? null,
						'cover_image' => $track->album->cover_image_path ?? $track->album->cover_image ?? null,
						'release_date' => $track->album->release_date ? $track->album->release_date->format('Y-m-d') : null,
						'total_tracks' => $track->album->tracks()->count() ?? 0,
					];
				}

				return [
					'id' => $track->id,
					'title' => $track->title,
					'description' => $track->description,
					'audio_file' => $track->audio_file_path ? $track->audio_file_path : null,
					'cover_image' => $track->cover_image_path ? $track->cover_image_path : null,
					'duration' => $track->duration,
					'is_explicit' => $track->is_explicit,
					'is_liked' => $track->likes()->where('user_id', auth()->id())->exists(),
					'plays_count' => $track->plays_count,
					'likes_count' => $track->likes_count,
					'trending_score' => round($trendingScore, 2),
					'last_played_at' => $track->last_played_at,
					'created_at' => $track->created_at->format('Y-m-d H:i:s'),
					'created_at_human' => $track->created_at->diffForHumans(),
					'artist' => [
						'id' => $track->artist->id,
						'name' => $track->artist->user->name ?? 'Unknown Artist',
						'profile_image' => $track->artist->user->profile_image ? $track->artist->user->profile_image : null,
					],
					'album' => $albumData
				];
			})->sortByDesc('trending_score')->take($limit)->values();

			return response()->json([
				'success' => true,
				'message' => 'Trending tracks fetched successfully',
				'data' => [
//					'time_range' => $timeRange,
					'total' => $tracks->count(),
					'tracks' => $tracks
				]
			]);

		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Error fetching trending tracks: ' . $e->getMessage()
			], 500);
		}
	}

    public function trending_tracks(Request $request)
	{
		try {
			$limit = $request->get('limit', 20);
			$timeRange = $request->get('time_range', 'all'); // day, week, month, all

			$tracksQuery = Track::with('artist.user');

			// Time range filter
			switch($timeRange) {
				case 'day':
					$tracksQuery->where('created_at', '>=', now()->subDay());
					break;
				case 'week':
					$tracksQuery->where('created_at', '>=', now()->subWeek());
					break;
				case 'month':
					$tracksQuery->where('created_at', '>=', now()->subMonth());
					break;
				case 'year':
					$tracksQuery->where('created_at', '>=', now()->subYear());
					break;
			}

			// Calculate trending score (plays + likes with weights)
			$tracks = $tracksQuery->get()->map(function($track) {
				$trendingScore = ($track->plays_count * 0.6) + ($track->likes_count * 0.4);

				// Recent activity boost (if played in last 24 hours)
				if ($track->last_played_at && $track->last_played_at >= now()->subDay()) {
					$trendingScore *= 1.2;
				}
			$albumData = null;
            if ($track->album) {
                $albumData = [
                    'id' => $track->album->id,
                    'title' => $track->album->title,
                    'slug' => $track->album->slug ?? null,
                    'cover_image' => $track->album->cover_image_path ?? $track->album->cover_image ?? null,
                    'release_date' => $track->album->release_date ? $track->album->release_date->format('Y-m-d') : null,
                    'total_tracks' => $track->album->tracks()->count() ?? 0,
                ];
            }

			return $track;
			})->sortByDesc('trending_score')->take($limit)->values();

			return response()->json([
				'success' => true,
				'message' => 'Trending tracks fetched successfully',
				'data' => [
					'time_range' => $timeRange,
					'total' => $tracks->count(),
					'tracks' => $tracks
				]
			]);

		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Error fetching trending tracks: ' . $e->getMessage()
			], 500);
		}
	}
	
	public function recently_played(Request $request)
	{
		try {
			$userId = auth()->user()->id; // Optional: specific user ke liye
			$limit = $request->get('limit', 20);

			// Agar user ID di hai to uske recent plays, nahi to sabke recent
			if ($userId) {
				$recentPlays = SongPlay::with(['track.artist.user'])
					->where('user_id', $userId)
					->orderBy('played_at', 'desc')
					->take($limit)
					->get();
			//} 
			//else {
			//	$recentPlays = SongPlay::with(['track.artist.user', 'user'])
			//		->orderBy('played_at', 'desc')
			//		->take($limit)
			//		->get();
			//}

				$formattedPlays = $recentPlays->map(function($play) {
					$track = $play->track;

					return [
						'play_id' => $play->id,
						'played_at' => $play->played_at,
						'played_at_human' => $play->played_at,
						'track' => [
							'id' => $track->id,
							'title' => $track->title,
							'audio_file' => $track->audio_file_path ?  $track->audio_file_path : null,
							'cover_image' => $track->cover_image_path ?  $track->cover_image_path : null,
							'is_explicit' => $track->is_explicit,
							'duration' => $track->duration,
							'plays_count' => $track->plays_count,
							'likes_count' => $track->likes_count,
						],
						'artist' => [
							'id' => $track->artist->id,
							'name' => $track->artist->user->name ?? 'Unknown Artist',
							'profile_image' => $track->artist->user->profile_image ?  $track->artist->user->profile_image : null,
						],
						'user' => $play->user ? [
							'id' => $play->user->id,
							'name' => $play->user->name,
						] : null
					];
				});

				return response()->json([
					'success' => true,
					'message' => 'Recently played tracks fetched successfully',
					'data' => [
						'total' => $formattedPlays->count(),
						'recently_played' => $formattedPlays
					]
				]);
			}
			else
			{
				return response()->json([
					'success' => true,
					'message' => 'Recently played tracks fetched successfully',
					'data' => null
				]);
			}

		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Error fetching recently played: ' . $e->getMessage()
			], 500);
		}
	}
	
	public function featuring_artists(Request $request)
	{
		try {
			$limit = $request->get('limit', 10);
			$type = $request->get('type', 'all'); // all, featured, popular, rising

			$artistsQuery = Artist::with('user', 'tracks');

			// Filter by type
			switch($type) {
				case 'featured':
					$artistsQuery->where('is_featured', true);
					break;
				case 'popular':
					$artistsQuery->withCount('tracks')
						->having('tracks_count', '>', 5)
						->orderBy('total_plays', 'desc');
					break;
				case 'rising':
					$artistsQuery->where('created_at', '>=', now()->subMonths(3))
						->orderBy('created_at', 'desc');
					break;
			}

			$artists = $artistsQuery->get()->map(function($artist) {
				$tracks = $artist->tracks;
				$totalPlays = $tracks->sum('plays_count');
				$totalLikes = $tracks->sum('likes_count');

				// Calculate popularity score
				$popularityScore = ($totalPlays * 0.5) + ($totalLikes * 0.3) + ($tracks->count() * 10);

				// Get top tracks
				$topTracks = $tracks->sortByDesc('plays_count')->take(3)->map(function($track) {
					return $track;
					// return [
					// 	'id' => $track->id,
					// 	'title' => $track->title,
					// 	'is_liked' => $track->likes()->where('user_id', auth()->user()->id)->exists(),
					// 	'plays_count' => $track->plays_count,
					// 	'cover_image' => $track->cover_image_path ?  $track->cover_image_path : null,
					// 	'is_explicit' => $track->is_explicit,
					// 	'audio_file' => $track->audio_file_path ?  $track->audio_file_path : null,
					// ];
				})->values();

				return [
					'id' => $artist->id,
					'artist_name' => $artist->user->name ?? 'Unknown Artist',
					'bio' => $artist->bio,
					'profile_image' => $artist->user->profile_image ? $artist->user->profile_image : null,
					'cover_image' => $artist->user->cover_image ?  $artist->user->cover_image : null,
					'is_featured' => $artist->is_featured ?? false,
					'featured_order' => $artist->featured_order ?? 0,
					'popularity_score' => round($popularityScore, 2),
					'statistics' => [
						'total_tracks' => $tracks->count(),
						'total_plays' => $totalPlays,
						'total_likes' => $totalLikes,
						'monthly_listeners' => $artist->monthly_listeners ?? rand(1000, 100000), // Example
					],
					'top_tracks' => $topTracks,
					'social_links' => [
						'spotify' => $artist->spotify_url ?? null,
						'youtube' => $artist->youtube_url ?? null,
						'instagram' => $artist->instagram_url ?? null,
					],
					'created_at' => $artist->created_at->format('Y-m-d H:i:s'),
					'created_at_human' => $artist->created_at->diffForHumans(),
				];
			})->sortByDesc(function($artist) use ($type) {
				if ($type === 'featured') {
					return $artist['featured_order'];
				}
				return $artist['popularity_score'];
			})->take($limit)->values();

			return response()->json([
				'success' => true,
				'message' => 'Featuring artists fetched successfully',
				'data' => [
					'type' => $type,
					'total' => $artists->count(),
					'artists' => $artists
				]
			]);

		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Error fetching featuring artists: ' . $e->getMessage()
			], 500);
		}
	}
    /**
     * Helper method to get similar artists based on various factors
     */
    /**
	 * Helper method to get similar artists based on various factors
	 */
	private function getSimilarArtists($artistId, $limit = 10)
    {
        // 1. Based on Listening Behavior
        $listeningBased = DB::table('song_plays as sp1')
            ->join('song_plays as sp2', 'sp1.user_id', '=', 'sp2.user_id')
            ->join('tracks as t1', 'sp1.track_id', '=', 't1.id')
            ->join('tracks as t2', 'sp2.track_id', '=', 't2.id')
            ->join('artists as a', 't2.artist_id', '=', 'a.id')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->where('t1.artist_id', $artistId)
            ->where('t2.artist_id', '!=', $artistId)
            ->whereNotNull('sp1.user_id')
            ->whereNotNull('sp2.user_id')
            ->select('a.id', 'u.name as artist_name', 'a.bio', DB::raw('COUNT(DISTINCT sp2.user_id) as listener_overlap'))
            ->groupBy('a.id', 'u.name', 'a.bio')
            ->orderBy('listener_overlap', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($item) {
                $topTrack = Track::where('artist_id', $item->id)->orderBy('play_count', 'desc')->first();
                return [
                    'id' => $item->id,
                    'name' => $item->artist_name,
                    'bio' => $item->bio,
                    'profile_image' => null,
                    'match_score' => min(100, $item->listener_overlap * 10),
                    'match_reason' => 'Listeners also enjoy this artist',
                    'top_track' => $topTrack ? [
                        'id' => $topTrack->id,
                        'title' => $topTrack->title,
						'is_explicit' => $topTrack->is_explicit,
						'is_liked' => $topTrack->likes()->where('user_id', auth()->user()->id)->exists(),
                        'cover_image' => $topTrack->cover_image_path ? $topTrack->cover_image_path : null,
                        'audio_file' => $topTrack->audio_file_path ? $topTrack->audio_file_path : null,
                    ] : null,
                ];
            });
        
        // 2. Based on Genre Similarity
        $artistGenreIds = Track::where('artist_id', $artistId)->whereNotNull('genre_id')->distinct()->pluck('genre_id');
        
        $genreBased = collect();
        if ($artistGenreIds->isNotEmpty()) {
            $genreBased = Artist::where('artists.id', '!=', $artistId)
                ->join('users', 'artists.user_id', '=', 'users.id')
                ->join('tracks', 'artists.id', '=', 'tracks.artist_id')
                ->whereIn('tracks.genre_id', $artistGenreIds)
                ->select('artists.id', 'users.name as artist_name', 'artists.bio', DB::raw('COUNT(DISTINCT tracks.id) as genre_match_count'))
                ->groupBy('artists.id', 'users.name', 'artists.bio')
                ->orderBy('genre_match_count', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($item) {
                    $topTrack = Track::where('artist_id', $item->id)->orderBy('play_count', 'desc')->first();
                    return [
                        'id' => $item->id,
                        'name' => $item->artist_name,
                        'bio' => $item->bio,
                        'match_score' => min(100, ($item->genre_match_count ?? 0) * 20),
                        'match_reason' => 'Similar music genre',
                        'top_track' => $topTrack ? [
                            'id' => $topTrack->id,
							'is_liked' => $topTrack->likes()->where('user_id', auth()->user()->id)->exists(),
                            'title' => $topTrack->title,
							'is_explicit' => $topTrack->is_explicit,
							'cover_image' => $topTrack->cover_image_path ? $topTrack->cover_image_path : null,
                            'audio_file' => $topTrack->audio_file_path ? $topTrack->audio_file_path : null,
                        ] : null,
                    ];
                });
        }
        
        // 3. Based on User Playlists
        $playlistBased = DB::table('playlist_track as pt1')
            ->join('playlist_track as pt2', 'pt1.playlist_id', '=', 'pt2.playlist_id')
            ->join('tracks as t1', 'pt1.track_id', '=', 't1.id')
            ->join('tracks as t2', 'pt2.track_id', '=', 't2.id')
            ->join('artists as a', 't2.artist_id', '=', 'a.id')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->where('t1.artist_id', $artistId)
            ->where('t2.artist_id', '!=', $artistId)
            ->select('a.id', 'u.name as artist_name', 'a.bio', DB::raw('COUNT(DISTINCT pt1.playlist_id) as playlist_count'))
            ->groupBy('a.id', 'u.name', 'a.bio')
            ->orderBy('playlist_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($item) {
                $topTrack = Track::where('artist_id', $item->id)->orderBy('play_count', 'desc')->first();
                return [
                    'id' => $item->id,
                    'name' => $item->artist_name,
                    'bio' => $item->bio,
                    'match_score' => min(100, ($item->playlist_count ?? 0) * 15),
                    'match_reason' => 'Often added to same playlists',
                    'top_track' => $topTrack ? [
                        'id' => $topTrack->id,
						'is_liked' => $topTrack->likes()->where('user_id', auth()->user()->id)->exists(),
                        'title' => $topTrack->title,
						'is_explicit' => $topTrack->is_explicit,
						'cover_image' => $topTrack->cover_image_path ? $topTrack->cover_image_path : null,
                        'audio_file' => $topTrack->audio_file_path ?  $topTrack->audio_file_path : null,
                    ] : null,
                ];
            });
        
        // Combine all
        $allRecommendations = collect()
            ->merge($listeningBased)
            ->merge($genreBased)
            ->merge($playlistBased)
            ->unique('id')
            ->sortByDesc('match_score')
            ->take($limit)
            ->values();
        
        return [
            'listening_behavior' => $listeningBased,
            'genre_based' => $genreBased,
            'playlist_based' => $playlistBased,
            'all' => $allRecommendations,
        ];
	}
    
    /**
     * 3. RECOMMENDED FOR TODAY - Personalized recommendations based on user history
     */
    /**
	 * 3. RECOMMENDED FOR TODAY - Personalized recommendations based on user history
	 */
	/**
	 * 3. RECOMMENDED FOR WEEK - Personalized recommendations based on user's weekly listening history
	 */
	public function recommendedForToday(Request $request)
	{
		$user = auth()->user();
		$limit = $request->get('limit', 20);
		$weeks = $request->get('weeks', 100); // Default 1 week, can be 2, 3, 4 etc.

		if (!$user) {
			// For guests, return general trending content
			return $this->trendingArtists($request);
		}

		$startDate = now()->subWeeks($weeks);

		// CACHE HATAYA - Direct query chal raha hai

		// Get user's most listened genre_ids from song_plays (last X weeks)
		$userGenreIds = DB::table('song_plays')
			->join('tracks', 'song_plays.track_id', '=', 'tracks.id')
			->where('song_plays.user_id', $user->id)
			->where('song_plays.played_at', '>=', $startDate)
			->whereNotNull('tracks.genre_id')
			->select('tracks.genre_id', DB::raw('COUNT(*) as listen_count'))
			->groupBy('tracks.genre_id')
			->orderBy('listen_count', 'desc')
			->pluck('genre_id');
		
		

		// Get genre names if you have a genres table
		$genreNames = [];
		if (class_exists('App\Models\Genre')) {
			$genreNames = \App\Models\Genre::whereIn('id', $userGenreIds)
				->pluck('name', 'id')
				->toArray();
		}

		// Get user's most listened artists in this period
		$userArtists = DB::table('song_plays')
			->join('tracks', 'song_plays.track_id', '=', 'tracks.id')
			->where('song_plays.user_id', $user->id)
			->where('song_plays.played_at', '>=', $startDate)
			->select('tracks.artist_id', DB::raw('COUNT(*) as listen_count'))
			->groupBy('tracks.artist_id')
			->orderBy('listen_count', 'desc')
			->pluck('artist_id');
		
		$isNewUser = $userGenreIds->isEmpty();

		if ($isNewUser) {
			// Return global recommendations for new users
			return $this->globalRecommendationsForNewUser($request);
		}

		// Get weekly statistics
		$totalListens = DB::table('song_plays')
			->where('user_id', $user->id)
			->where('played_at', '>=', $startDate)
			->count();

		$uniqueArtists = DB::table('song_plays')
			->join('tracks', 'song_plays.track_id', '=', 'tracks.id')
			->where('song_plays.user_id', $user->id)
			->where('song_plays.played_at', '>=', $startDate)
			->distinct('tracks.artist_id')
			->count('tracks.artist_id');

		// Get recommendations based on weekly listening:

		// 1. Similar artists to their weekly favorites
		$similarToFavorites = collect();
		foreach ($userArtists->take(3) as $artistId) {
			$similar = $this->getSimilarArtists($artistId, 5);
			$similarToFavorites = $similarToFavorites->merge($similar['all'] ?? []);
		}

		// 2. New releases from favorite genres (last 4 weeks)
		$newReleases = collect();
		if ($userGenreIds->isNotEmpty()) {
			$newReleases = Track::whereIn('genre_id', $userGenreIds->take(3))
				->where('created_at', '>=', now()->subWeeks(4))
				->with('artist.user')
				->orderBy('created_at', 'desc')
				->take(10)
				->get()
				->map(function($track) use ($genreNames) {
					$recentPlays = SongPlay::where('track_id', $track->id)
						->where('played_at', '>=', now()->subWeek())
						->count();

					$artistName = $track->artist->user->name ?? 'Unknown Artist';
					$genreName = $genreNames[$track->genre_id] ?? 'Unknown Genre';
					$isLiked = $track->likes()->where('user_id', auth()->user()->id)->exists();
					return $track;
					// return [
					// 	'type' => 'track',
					// 	'id' => $track->id,
					// 	'title' => $track->title,
					// 	'artist' => $artistName,
					// 	'artist_id' => $track->artist_id,
					// 	'genre' => $genreName,
					// 	'is_liked' => $isLiked,
					// 	'cover_image' => $track->cover_image_path ?  $track->cover_image_path : null,
					// 	'audio_file' => $track->audio_file_path ?  $track->audio_file_path : null,
					// 	'duration' => $track->duration,
					// 	'is_explicit' => $track->is_explicit,
					// 	'recent_plays' => $recentPlays,
					// 	'released_at' => $track->created_at->format('Y-m-d'),
					// 	'released_weeks_ago' => $track->created_at->diffInWeeks(now()),
					// 	'reason' => 'New release from genre you like',
					// ];
				});
		}

		// 3. Weekly trending tracks (most played in last 7 days)
		$weeklyTrending = Track::whereHas('plays', function($query) {
				$query->where('played_at', '>=', now()->subWeek());
			})
			->with('artist.user')
			->withCount(['plays as weekly_plays' => function($query) {
				$query->where('played_at', '>=', now()->subWeek());
			}])
			->orderBy('weekly_plays', 'desc')
			->take(15)
			->get()
			->map(function($track) {
				$artistName = $track->artist->user->name ?? 'Unknown Artist';
				$isLiked = $track->likes()->where('user_id', auth()->user()->id)->exists();

				return $track;
				// return [
				// 	'type' => 'track',
				// 	'id' => $track->id,
				// 	'title' => $track->title,
				// 	'artist' => $artistName,
				// 	'is_liked' => $isLiked,
				// 	'artist_id' => $track->artist_id,
				// 	'cover_image' => $track->cover_image_path ?  $track->cover_image_path : null,
				// 	'audio_file' => $track->audio_file_path ? $track->audio_file_path : null,
				// 	'weekly_plays' => $track->weekly_plays,
				// 	'is_explicit' => $track->is_explicit,
				// 	'reason' => 'Trending this week',
				// ];
			});

		// 4. This Week's Discovery Mix (based on listening patterns)
		$discoveryMix = $this->getDiscoveryMix($user, $userGenreIds, $userArtists, $limit);

		// 5. Weekly Top Hits (user's most played this week)
		$topTrackIds = DB::table('song_plays')
			->select('track_id', DB::raw('COUNT(*) as play_count'))
			->where('user_id', $user->id)
			->where('played_at', '>=', $startDate)
			->groupBy('track_id')
			->orderBy('play_count', 'desc')
			->limit(10)
			->pluck('track_id');

		$yourWeeklyTop = collect();
		if ($topTrackIds->isNotEmpty()) {
			$yourWeeklyTop = Track::whereIn('id', $topTrackIds)
				->with('artist.user')
				->get()
				->map(function($track) {
					$artistName = $track->artist->user->name ?? 'Unknown Artist';
					$isLiked = $track->likes()->where('user_id', auth()->user()->id)->exists();

					return $track;
					// return [
					// 	'type' => 'track',
					// 	'id' => $track->id,
					// 	'title' => $track->title,
					// 	'artist' => $artistName,
					// 	'is_liked' => $isLiked,
					// 	'artist_id' => $track->artist_id,
					// 	'cover_image' => $track->cover_image_path ? $track->cover_image_path : null,
					// 	'audio_file' => $track->audio_file_path ?  $track->audio_file_path : null,
					// 	'duration' => $track->duration,
					// 	'is_explicit' => $track->is_explicit,
					// 	'reason' => 'Your top track this week',
					// ];
				});
		}

		$recommendations[] = [
			'week_summary' => [
				'weeks_analyzed' => $weeks,
				'period' => $startDate->format('M d') . ' - ' . now()->format('M d, Y'),
				'total_listens' => $totalListens,
				'unique_artists' => $uniqueArtists,
				'top_genres' => $userGenreIds->take(3)->map(function($id) use ($genreNames) {
					return $genreNames[$id] ?? 'Genre ' . $id;
				})->values(),
			],
		];
		$recommendations[] = [
		'your_weekly_top' => [
				'title' => 'Your Weekly Top Hits',
				'items' => $yourWeeklyTop,
			],
		];
		
		$recommendations[] = [
			'weekly_discovery' => [
				'title' => 'Discovery Mix - New For You This Week',
				'items' => $discoveryMix,
			],
		];
			
		$recommendations[] = [
			'weekly_trending' => [
				'title' => 'Trending This Week',
				'items' => $weeklyTrending,
			],
		];
			
		$recommendations[] = [
			'new_releases' => [
				'title' => 'New Releases This Month',
				'items' => $newReleases,
			],
		];
			
		// $recommendations[] = [
		// 	'similar_artists' => [
		// 		'title' => 'Because You Listened To',
		// 		'items' => $similarToFavorites->unique('id')->take($limit)->values(),
		// 	],
		// ];
			

		return response()->json([
			'success' => true,
			'message' => "Recommended for week " . now()->format('W'),
			'week_number' => now()->format('W'),
			'year' => now()->year,
			'data' => [$recommendations]
		]);
	}

	private function globalRecommendationsForNewUser(Request $request)
	{
		$limit = $request->get('limit', 20);

		// 1. Global trending tracks (all time or last 30 days)
		$globalTrending = Track::whereHas('plays', function($query) {
				$query->where('played_at', '>=', now()->subDays(30));
			})
			->with('artist.user')
			->withCount(['plays as total_plays'])
			->orderBy('total_plays', 'desc')
			->take($limit)
			->get()
			->map(function($track) {
				return [
					'type' => 'track',
					'id' => $track->id,
					'title' => $track->title,
					'artist' => $track->artist->user->name ?? 'Unknown Artist',
					'artist_id' => $track->artist_id,
					'cover_image' => $track->cover_image_path ?  $track->cover_image_path : null,
					'audio_file' => $track->audio_file_path ?  $track->audio_file_path : null,
					'duration' => $track->duration,
					'is_explicit' => $track->is_explicit,
					'reason' => 'Global trending track',
				];
			});

		// 2. Featured artists
		$featuredArtists = User::role('artist')
			//->where('featured', 1)
			->with('artist')
			->take(10)
			->get();

		// 3. Recently added tracks (last 2 weeks)
		$recentTracks = Track::where('created_at', '>=', now()->subWeeks(2))
			->with('artist.user')
			->orderBy('created_at', 'desc')
			->take($limit)
			->get()
			->map(function($track) {
				return [
					'type' => 'track',
					'id' => $track->id,
					'title' => $track->title,
					'artist' => $track->artist->user->name ?? 'Unknown Artist',
					'artist_id' => $track->artist_id,
					'is_explicit' => $track->is_explicit,
					'cover_image' => $track->cover_image_path ?  $track->cover_image_path : null,
					'audio_file' => $track->audio_file_path ? $track->audio_file_path : null,
					'reason' => 'Fresh new track',
				];
			});

		$recommendations = [
			[
				'welcome_message' => [
					'title' => 'Welcome to the App! 🎵',
					'subtitle' => 'Here are some trending tracks to get you started',
				]
			],
			[
				'global_trending' => [
					'title' => '🔥 Global Trending',
					'items' => $globalTrending,
				]
			],
			[
				'new_releases' => [
					'title' => '🆕 Fresh Releases',
					'items' => $recentTracks,
				]
			],
			[
				'featured_artists' => [
					'title' => '⭐ Featured Artists',
					'items' => $featuredArtists,
				]
			]
		];

		return response()->json([
			'success' => true,
			'message' => 'Recommended for you (new user)',
			'is_new_user' => true,
			'data' => $recommendations
		]);
	}

	/**
	 * Helper: Get discovery mix for week
	 */
	private function getDiscoveryMix($user, $userGenreIds, $userArtists, $limit)
	{
		// Combine different discovery strategies

		// 1. Tracks from similar artists that user hasn't heard
		$fromSimilarArtists = collect();
		foreach ($userArtists->take(2) as $artistId) {
			$similar = $this->getSimilarArtists($artistId, 3);
			$similarArtistIds = collect($similar['all'] ?? [])->pluck('id');

			// Get tracks user hasn't heard
			$heardTrackIds = DB::table('song_plays')
				->where('user_id', $user->id)
				->pluck('track_id');

			$tracks = Track::whereIn('artist_id', $similarArtistIds)
				->when($heardTrackIds->isNotEmpty(), function($query) use ($heardTrackIds) {
					return $query->whereNotIn('id', $heardTrackIds);
				})
				->with('artist.user')
				->inRandomOrder()
				->limit(5)
				->get()
				->map(function($track) {
					$artistName = $track->artist->user->name ?? 'Unknown Artist';
					$isLiked = $track->likes()->where('user_id', auth()->user()->id)->exists();
					return [
						'id' => $track->id,
						'title' => $track->title,
						'artist' => $artistName,
						'is_liked' => $isLiked,
						'artist_id' => $track->artist_id,
						'is_explicit' => $track->is_explicit,
						'cover_image' => $track->cover_image_path ?  $track->cover_image_path: null,
						'audio_file' => $track->audio_file_path ? $track->audio_file_path : null,
						'reason' => 'Similar to artists you like',
					];
				});

			$fromSimilarArtists = $fromSimilarArtists->merge($tracks);
		}

		// 2. Popular tracks from user's favorite genres
		$genreBased = collect();
		if ($userGenreIds->isNotEmpty()) {
			$heardTrackIds = DB::table('song_plays')
				->where('user_id', $user->id)
				->pluck('track_id');

			$genreBased = Track::whereIn('genre_id', $userGenreIds->take(2))
				->when($heardTrackIds->isNotEmpty(), function($query) use ($heardTrackIds) {
					return $query->whereNotIn('id', $heardTrackIds);
				})
				->with('artist.user')
				->orderBy('play_count', 'desc')
				->limit(10)
				->get()
				->map(function($track) {
					$artistName = $track->artist->user->name ?? 'Unknown Artist';
					$isLiked = $track->likes()->where('user_id', auth()->user()->id)->exists();

					return [
						'id' => $track->id,
						'title' => $track->title,
						'artist' => $artistName,
						'is_liked' => $isLiked,
						'artist_id' => $track->artist_id,
						'is_explicit' => $track->is_explicit,
						'cover_image' => $track->cover_image_path ? $track->cover_image_path : null,
						'audio_file' => $track->audio_file_path ?  $track->audio_file_path : null,
						'reason' => 'Popular in your favorite genres',
					];
				});
		}

		// Combine and shuffle for discovery mix
		return $fromSimilarArtists
			->merge($genreBased)
			->shuffle()
			->take($limit)
			->values();
	}
    
    /**
     * 4. RECENT ARTISTS - Recently played artists by user
     */
    /**
	 * 4. RECENT ARTISTS - Recently played artists by user
	 */
	public function recentArtists(Request $request)
	{
		$user = $request->user();
		$limit = $request->get('limit', 10);

		if (!$user) {
			return response()->json([
				'success' => true,
				'message' => 'Login to see your recent artists',
				'data' => []
			]);
		}

		$recentArtists = SongPlay::where('user_id', $user->id)
			->with('track.artist.user')
			->select('track_id', 'played_at')
			->orderBy('played_at', 'desc')
			->get()
			->groupBy(function($play) {
				return $play->track->artist_id;
			})
			->map(function($plays, $artistId) {
				$latestPlay = $plays->first();
				$artist = $latestPlay->track->artist;
				$playCount = $plays->count();

				// FIXED: Convert played_at to Carbon instance if it's a string
				$playedAt = $latestPlay->played_at;
				if (is_string($playedAt)) {
					$playedAt = \Carbon\Carbon::parse($playedAt);
				}

				// Get top track from this artist
				$topTrack = Track::where('artist_id', $artistId)
					->orderBy('play_count', 'desc')
					->first();

				// Get artist name from users table
				$artistName = $artist->user->name ?? 'Unknown Artist';
				$isLiked = $topTrack->likes()->where('user_id', auth()->user()->id)->exists();

				return [
					'id' => $artist->id,
					'name' => $artistName,
					'bio' => $artist->bio,
					'profile_image' => null, // Add if you have this column
					'cover_image' => null,    // Add if you have this column
					'last_listened' => $playedAt->toDateTimeString(),
					'time_ago' => $playedAt->diffForHumans(), // Now safe to call
					'total_plays' => $playCount,
					'top_track' => $topTrack ? [
						'id' => $topTrack->id,
						'title' => $topTrack->title,
						'play_count' => $topTrack->play_count,
						'is_explicit' => $topTrack->is_explicit,
						'is_liked' =>$isLiked,
						'cover_image' => $topTrack->cover_image_path ?  $topTrack->cover_image_path : null,
						'audio_file' => $topTrack->audio_file_path, // YEH already hai
						
					] : null,
				];
			})
			->sortByDesc(function($item) {
				// Sort by last_listened timestamp
				return $item['last_listened'];
			})
			->take($limit)
			->values();

		return response()->json([
			'success' => true,
			'message' => 'Your recently played artists',
			'data' => $recentArtists
		]);
	}
    
    /**
     * 5. BEST ARTISTS - Top artists overall (all-time, yearly, monthly, weekly)
     */
    public function bestArtists(Request $request)
	{
		$period = $request->get('period', 'all'); // all, year, month, week
		$limit = $request->get('limit', 20);
		$trackLimit = $request->get('track_limit', 5); // kitne top tracks chahiye
		
		$query = Artist::query()->withCount('likes')->with('user'); // user relation load karo
		
		if ($period === 'week') {
			$startDate = now()->subWeek();
			$query->withCount(['tracks as period_plays' => function($q) use ($startDate) {
				$q->join('song_plays', 'tracks.id', '=', 'song_plays.track_id')
				->where('song_plays.played_at', '>=', $startDate);
			}])->orderBy('period_plays', 'desc');
			
		} elseif ($period === 'month') {
			$startDate = now()->subMonth();
			$query->withCount(['tracks as period_plays' => function($q) use ($startDate) {
				$q->join('song_plays', 'tracks.id', '=', 'song_plays.track_id')
				->where('song_plays.played_at', '>=', $startDate);
			}])->orderBy('period_plays', 'desc');
			
		} elseif ($period === 'year') {
			$startDate = now()->subYear();
			$query->withCount(['tracks as period_plays' => function($q) use ($startDate) {
				$q->join('song_plays', 'tracks.id', '=', 'song_plays.track_id')
				->where('song_plays.played_at', '>=', $startDate);
			}])->orderBy('period_plays', 'desc');
			
		} else {
			// All-time - based on total play_count from tracks table
			$query->withSum('tracks', 'play_count')
				->orderBy('tracks_sum_play_count', 'desc');
		}
		
		// Eager load tracks for N+1 prevention
		$query->with(['tracks' => function($q) use ($trackLimit) {
			$q->orderBy('play_count', 'desc')->limit($trackLimit)->withCount('likes');
		}]);
		
		
		$artists = $query->limit($limit)->get()->map(function($artist) use ($period, $trackLimit) {
			$totalPlays = $period !== 'all' 
				? ($artist->period_plays ?? 0)
				: ($artist->tracks_sum_play_count ?? 0);
			
			// Get unique listeners count
			$uniqueListeners = SongPlay::whereIn('track_id', $artist->tracks->pluck('id'))
				->distinct('user_id')
				->count('user_id');
			
			
			// Get top tracks (already eager loaded)
			$topTracks = $artist->tracks->map(function($track) {
				$isLiked = $track->likes()->where('user_id', auth()->user()->id)->exists();
				return  $track->is_liked = $isLiked;

			});
			
			return $artist;
		});
		
		return response()->json([
			'success' => true,
			'message' => "Best Artists - {$period}",
			'period' => $period,
			'data' => $artists
		]);
	}
    
    /**
     * 6. TRENDING ARTISTS - Fastest growing artists right now
     */
    public function trendingArtists(Request $request)
	{
		$limit = $request->get('limit', 20);
		$days = $request->get('days', 7);

		$startDate = now()->subDays($days);
		$previousStartDate = now()->subDays($days * 2);
		$previousEndDate = now()->subDays($days);

		// Get artists with their play counts using withCount
		$artists = Artist::withCount(['tracks as current_period_listens' => function($query) use ($startDate) {
				$query->join('song_plays', 'tracks.id', '=', 'song_plays.track_id')
					  ->where('song_plays.played_at', '>=', $startDate);
			}])
			->having('current_period_listens', '>', 0)
			->orderBy('current_period_listens', 'desc')
			->limit($limit * 2)
			->get();

		$trendingArtists = $artists->map(function($artist) use ($startDate, $previousStartDate, $previousEndDate, $days) {
			$currentListens = $artist->current_period_listens ?? 0;

			$previousListens = SongPlay::whereIn('track_id', $artist->tracks->pluck('id'))
				->whereBetween('played_at', [$previousStartDate, $previousEndDate])
				->count();

			$growthRate = $previousListens > 0 
				? round((($currentListens - $previousListens) / $previousListens) * 100, 1)
				: 100;

			if ($growthRate <= 0 || $currentListens < 10) return null;

			$user = \App\Models\User::find($artist->user_id);
			$artistName = $user->name ?? 'Unknown Artist';

			return [
				'id' => $artist->id,
				'name' => $artistName,
				'bio' => $artist->bio,
				'current_listens' => $currentListens,
				'previous_listens' => $previousListens,
				'growth_percentage' => $growthRate,
				'trending_score' => round(($currentListens * 0.3) + ($growthRate * 0.7), 1),
			];
		})->filter()->sortByDesc('trending_score')->take($limit)->values();

		return response()->json([
			'success' => true,
			'message' => "Trending Artists (Last {$days} days)",
			'data' => $trendingArtists
		]);
	}
    
    /**
     * Helper: Get daily mix for user
     */
    private function getDailyMix($user, $limit)
    {
        // Get user's top artists from song_plays
        $userArtists = DB::table('song_plays')
            ->join('tracks', 'song_plays.track_id', '=', 'tracks.id')
            ->where('song_plays.user_id', $user->id)
            ->select('tracks.artist_id', DB::raw('COUNT(*) as listen_count'))
            ->groupBy('tracks.artist_id')
            ->orderBy('listen_count', 'desc')
            ->limit(5)
            ->pluck('artist_id');
        
        if ($userArtists->isEmpty()) {
            // If no history, return trending tracks
            return Track::with('artist')
                ->withCount(['plays as recent_plays' => function($q) {
                    $q->where('played_at', '>=', now()->subDays(3));
                }])
                ->orderBy('recent_plays', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($track) {
                    return [
                        'type' => 'track',
                        'id' => $track->id,
                        'title' => $track->title,
                        'artist' => $track->artist->name,
                        'artist_id' => $track->artist_id,
                        'cover_image' => $track->cover_image ?  $track->cover_image : null,
                        'audio_file' => $track->audio_file_path ? $track->audio_file_path : null,
                        'duration' => $track->duration,
						'is_explicit' => $track->is_explicit,
                        'reason' => 'Trending now',
                    ];
                });
        }
        
        // Get mix of popular and recent tracks from user's favorite artists
        $mix = Track::whereIn('artist_id', $userArtists)
            ->with('artist')
            ->inRandomOrder() // Daily mix should be different each day
            ->limit($limit)
            ->get()
            ->map(function($track) {
                return [
                    'type' => 'track',
                    'id' => $track->id,
                    'title' => $track->title,
                    'artist' => $track->artist->name,
                    'artist_id' => $track->artist_id,
                    'cover_image' => $track->cover_image ? $track->cover_image : null,
                    'audio_file' => $track->audio_file_path ? $track->audio_file_path : null,
                    'duration' => $track->duration,
					'is_explicit' => $track->is_explicit,
                    'play_count' => $track->play_count,
                    'reason' => 'Because you listened to ' . $track->artist->name,
                ];
            });
        
        return $mix;
    }
    
    /**
     * Combined dashboard with all recommendations
     */
    public function recommendationDashboard(Request $request)
    {
        $user = $request->user();
        
        $data = [
            'featuring_artist' => $this->featuringArtist($request)->getData()->data,
            'trending_artists' => $this->trendingArtists($request)->getData()->data,
            'best_artists_this_month' => $this->bestArtists(new Request(['period' => 'month', 'limit' => 10]))->getData()->data,
        ];
        
        if ($user) {
            $data['recommended_for_today'] = $this->recommendedForToday($request)->getData()->data;
            $data['recent_artists'] = $this->recentArtists($request)->getData()->data;
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Recommendation Dashboard',
            'data' => $data
        ]);
    }
}