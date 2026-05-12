<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Genre;
use App\Models\SongPlay;
use App\Models\User;
use App\Models\Artist;
use App\Models\Event;
use App\Models\Track;
use Auth;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Storage;
use App\Http\Resources\AlbumResource;

class TrackController extends BaseController
{
    public function admin_update(Request $request, Track $track)
    {
        $request->validate([
            'royalty_amount' => 'required|numeric|min:0',
            'play_count' => 'required|integer|min:0',
        ]);

        $track->update([
            'royalty_amount' => $request->input('royalty_amount'),
            'play_count' => $request->input('play_count'),
        ]);

        return redirect()->back()->with('success', 'Track details updated successfully.');
    }
	
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Query is required',
            ], 400);
        }
        
        $tracks = Track::with('artist.user')->where('title', 'like', "%{$query}%")->get();
        
        
        $matchingUserIds = User::where('name', 'like', "%{$query}%")->pluck('id');

        $artists = Artist::with('user')
        ->whereIn('user_id', $matchingUserIds)
        ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Tracks found successfully',
            'tracks' => $tracks,
            'artists' => $artists,
        ]);
    }
	
	public function downloadTrack(Request $request, $trackId)
    {
		//2ndoption
		$track = Track::findOrFail($trackId);
    
		// Generate signed URL (expires in 1 hour)
		$url = Storage::temporaryUrl(
			$track->audio_file_path,
			now()->addHour(),
			['ResponseContentDisposition' => 'attachment']
		);

		return response()->json([
			'success' => true,
			'download_url' => $url,
			'metadata' => [
				'track_id' => $track->id,
				'title' => $track->title,
				'artist' => $track->artist->user->name,
				'duration' => $track->duration,
			]
		]);
		//2ndoption end
		
		
        $user = $request->user();
        $track = Track::with('artist.user')->findOrFail($trackId);
        
        // Get audio file path
        $audioPath = storage_path('app/public/' . $track->audio_file_path);
        
        if (!file_exists($audioPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Audio file not found'
            ], 404);
        }
        
        // Read audio file and convert to base64
        $audioContent = base64_encode(file_get_contents($audioPath));
        
        // Get cover image if exists
        $coverContent = null;
        if ($track->cover_image_path && file_exists(storage_path('app/public/' . $track->cover_image_path))) {
            $coverContent = base64_encode(file_get_contents(storage_path('app/public/' . $track->cover_image_path)));
        }
        
        // Return complete package
        return response()->json([
            'success' => true,
            'message' => 'Track ready for offline download',
            'data' => [
                'track_id' => $track->id,
                'title' => $track->title,
                'artist_name' => $track->artist->user->name ?? 'Unknown',
                'artist_id' => $track->artist_id,
                'duration' => $track->duration,
                'genre_id' => $track->genre_id,
                'audio_base64' => $audioContent,
                'cover_base64' => $coverContent,
                'file_size' => filesize($audioPath),
                'downloaded_at' => now()->toDateTimeString(),
            ]
        ]);
    }

    public function track_list()
    {
        $tracks = Track::where('approved', true)->with('artist.user','album','genre')->paginate(20);
		return response()->json(['success'=>true,'message'=>'Track List','track_list'=>$tracks]);
    }
	
	public function trackPlay($trackId)
    {
        $track = Track::findOrFail($trackId);
        if($track) {

            SongPlay::create([
                'user_id' => Auth::id(),
                'track_id' => $track->id,
            ]);
        }
		return response()->json(['success'=>true,'message'=>'Track Play']);
    }

    public function album_tracks($albumid)
    {
        $tracks = Album::with('tracks','tracks.artist.user','tracks.genre')->find($albumid);
		return response()->json(['success'=>true,'message'=>'Album Detail','album_list'=>$tracks]);
    }
	
	public function genres_list()
    {
        $tracks = Genre::paginate(20);
		return response()->json(['success'=>true,'message'=>'Genres List','track_list'=>$tracks]);
    }
	
	public function genres_detail($id)
	{
	    $tracksids = Track::where('genre_id', $id)->with('album')->pluck('album_id');
		$album = Album::with('tracks.artist')->whereIn('id',$tracksids)->get();
		return response()->json(['success'=>true,'message'=>'Genres List','track_list'=>AlbumResource::collection($album)]);
	}
	
    public function getTrack($trackId)
    {
        $track = Track::with('artist.user')->findOrFail($trackId);
        return response()->json(['track' => $track]);
    }
	
	public function artist_list(Request $request)
	{
		$perPage = $request->get('per_page', 10);
		$artists = Artist::with('user', 'tracks')
			->paginate($perPage);

		$formattedArtists = collect($artists->items())->map(function($artist) {
			$tracks = $artist->tracks;

			// Format tracks
			$formattedTracks = $tracks->map(function($track) {
				$isLiked = $track->likes()->where('user_id', auth()->user()->id)->exists();
				return [
					'id' => $track->id,
					'title' => $track->title,
					'description' => $track->description,
					'audio_file' => $track->audio_file_path ?  $track->audio_file_path : null,
					'cover_image' => $track->cover_image_path ?  $track->cover_image_path : null,
					'duration' => $track->duration,
					'plays_count' => $track->plays_count,
					'likes_count' => $track->likes_count,
					'is_liked' => $isLiked,
					'created_at' => $track->created_at->format('Y-m-d H:i:s'),
					'created_at_human' => $track->created_at->diffForHumans(),
					'genre' => $track->genre,
					'featured' => $track->featured ?? false,
				];
			});

			return [
				'id' => $artist->id,
				'artist_name' => $artist->user->name,
				'profile_image' => $artist->user->profile_image ? $artist->user->profile_image : null,
				//'cover_image' => $artist->user->cover_image ? $artist->user->cover_image : null,
				'bio' => $artist->bio,
				'statistics' => [
					'total_tracks' => $tracks->count(),
					//'total_plays' => $tracks->sum('plays_count'),
					'total_followers' => $artist->likes->count(),
				],
				'all_tracks' => $formattedTracks->values(),
				'latest_tracks' => $formattedTracks->sortByDesc('created_at')->take(3)->values(),
			];
		});

		return response()->json([
			'success' => true,
			'message' => 'Artist List',
			'data' => [
				'artists' => $formattedArtists,
				'pagination' => [
					'current_page' => $artists->currentPage(),
					'last_page' => $artists->lastPage(),
					'per_page' => $artists->perPage(),
					'total' => $artists->total(),
					'next_page_url' => $artists->nextPageUrl(),
					'prev_page_url' => $artists->previousPageUrl(),
				]
			]
		]);
	}
	
	public function events_list()
    {
        $users = Event::with('artist')->get()->unique('artist_id');
		return response()->json(['success'=>true,'message'=>'Event List','event_list'=>$users]);
    }


    public function events_by_artist($artistid)
    {
        $users = Event::with('artist')->where('artist_id',$artistid)->get();
		return response()->json(['success'=>true,'message'=>'Event List','event_list'=>$users]);
    }

    

    // Log the play action for a track
    
    public function approve($id)
    {
        $track = Track::findOrFail($id);
        $track->approved = true;
        $track->save();

        // Optionally, notify the artist about approval
        // event(new TrackApproved($track));

        return redirect()->route('admin.track-approvals.index')->with('success', 'Track approved successfully.');
    }

    public function reject($id)
    {
        $track = Track::findOrFail($id);
        if ($track->audio_file_path) {
            Storage::disk('public')->delete($track->audio_file_path);
        }
        if ($track->cover_image_path) {
            Storage::disk('public')->delete($track->cover_image_path);
        }
        // Optionally, provide a reason for rejection
        $track->delete(); // Or set a status as rejected

        return redirect()->route('admin.track-approvals.index')->with('success', 'Track rejected successfully.');
    }
    public function index(Request $request)
    {
        $query = Track::where('artist_id', auth()->user()->artist->id)->with('album');

        // Filter by approval status
        if ($request->has('status') && in_array($request->status, ['approved', 'pending'])) {
            $approved = $request->status === 'approved' ? true : false;
            $query->where('approved', $approved);
        }

        // Search by title or genre
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('genre', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $tracks = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());

        return view('artist.tracks.index', compact('tracks'));
    }

    public function create()
    {
        $genres = Genre::all();
        $albums = Album::where('artist_id', Auth::user()->artist->id)->get();

        return view('artist.tracks.create', compact('genres', 'albums'));
    }

    public function store(Request $request)
    {
        // Permission check (redundant if using middleware)
        // if (!auth()->user()->can('upload tracks')) {
        //     abort(403, 'Unauthorized action.');
        // }
// dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'album_id' => 'required|exists:albums,id',
            'audio_file' => 'required|mimes:mp3,wav,ogg|max:20000', // Max 20MB
            'cover_image' => 'required|image|max:5000',
            'description' => 'nullable|string',
            'play_count' => 'nullable|string',
            'royalty_amount' => 'nullable|string',
            'duration' => 'required',
        ]);

        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('tracks/audio', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('tracks/covers', 'public');
        } else {
            $coverImagePath = null;
        }

        // $duration = FFMpeg::fromDisk('public')
        //     ->open($audioPath)
        //     ->getDurationInSeconds();

        $track = Track::create([
            'album_id' => $request->album_id,
            'artist_id' => auth()->user()->artist->id,
            'title' => $request->title,
            'genre_id' => $request->genre_id,
            // 'duration' => ceil($duration),
            'duration' => $request->duration ?? 0,
            'audio_file_path' => $audioPath,
            'cover_image_path' => $coverImagePath,
            'description' => $request->description,
            'play_count' => $request->play_count,
            'royalty_amount' => $request->royalty_amount,
            'approved' => false,
        ]);

        return redirect()->route('artist.tracks.index', $track->id)->with('success', 'Track uploaded successfully and is pending approval.');
    }

    public function show($id)
    {
        $track = Track::findOrFail($id);
        if (Auth::user()->hasRole('admin')) {

            return view('artist.tracks.adminShow', compact('track'));
        } else {

            return view('artist.tracks.show', compact('track'));
        }
    }

    public function edit($id)
    {
        $track = Track::where('artist_id', Auth::user()->artist->id)
            ->findOrFail($id);

        $genres = Genre::all();
        $albums = Album::where('artist_id', Auth::user()->artist->id)->get();

        return view('artist.tracks.edit', compact('track', 'genres', 'albums'));
    }

    public function update(Request $request, $id)
    {
        $track = Track::where('artist_id', Auth::user()->artist->id)
            ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'album_id' => 'required|exists:albums,id',
            'audio_file' => 'nullable|mimes:mp3,wav,ogg|max:20000',
            'cover_image' => 'required|image|max:5000',
            'description' => 'nullable|string',
            'duration' => 'required',
        ]);

        // Handle audio file upload
        if ($request->hasFile('audio_file')) {
            // Delete old audio file
            if ($track->audio_file_path) {
                Storage::disk('public')->delete($track->audio_file_path);
            }
            $audioPath = $request->file('audio_file')->store('tracks/audio', 'public');
            $track->audio_file_path = $audioPath;
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($track->cover_image_path) {
                Storage::disk('public')->delete($track->cover_image_path);
            }
            $coverImagePath = $request->file('cover_image')->store('tracks/covers', 'public');
            $track->cover_image_path = $coverImagePath;
        }

        $track->title = $request->title;
        $track->genre_id = $request->genre_id;
        $track->duration = $request->duration;
        $track->album_id = $request->album_id;
        $track->description = $request->description;
        $track->approved = false; // Re-approve after editing
        $track->save();

        return redirect()->route('artist.tracks.show', $track->id)->with('success', 'Track updated successfully and is pending approval.');
    }
    public function destroy($id)
    {
        if (Auth::user()->hasRole('admin')) {

            $track = Track::findOrFail($id);
        } else {

            $track = Track::where('artist_id', Auth::user()->artist->id)
                ->findOrFail($id);
        }

        // Delete associated files
        if ($track->audio_file_path) {
            Storage::disk('public')->delete($track->audio_file_path);
        }
        if ($track->cover_image_path) {
            Storage::disk('public')->delete($track->cover_image_path);
        }

        $track->delete();

        if (Auth::user()->hasRole('admin')) {

            return redirect()->route('admin.track-approvals.index')->with('success', 'Track deleted successfully.');
        } else {

            return redirect()->route('artist.tracks.index')->with('success', 'Track deleted successfully.');
        }
    }
    public function stream($id)
    {
        $track = Track::findOrFail($id);

        // Optionally, check if the user has permission to stream

        $path = storage_path('app/public/' . $track->audio_file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = fopen($path, 'rb');
        $size = filesize($path);
        $mime = mime_content_type($path);
        $headers = [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ];

        return response()->stream(function () use ($file) {
            fpassthru($file);
        }, 200, $headers);
    }
}
