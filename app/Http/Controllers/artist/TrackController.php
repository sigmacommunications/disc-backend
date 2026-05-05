<?php

namespace App\Http\Controllers\artist;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Genre;
use App\Models\SongPlay;
use App\Models\Track;
use Auth;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Storage;

class TrackController extends Controller
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

    public function Appindex()
    {
        $tracks = Track::where('approved', false)->with('artist')->paginate(20);
        return view('admin.track_approvals.index', compact('tracks'));
    }
    public function getTrack($trackId)
    {
        $track = Track::with('artist.user')->findOrFail($trackId);
        return response()->json(['track' => $track]);
    }

    // Log the play action for a track
    public function trackPlay($trackId)
    {
        dd($trackId);

        $track = Track::findOrFail($trackId);
        if (auth()->check()) {

            SongPlay::create([
                'user_id' => Auth::id(),
                'track_id' => $track->id,
            ]);
        }
        return response()->json(['success' => true]);
    }
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
