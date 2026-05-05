<?php

namespace App\Http\Controllers\artist;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Storage;

class AlbumController extends Controller
{
    public function index()
    {
        // Retrieve albums for the authenticated artist, paginated
        $albums = Album::where('artist_id', auth()->user()->artist->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Adjust pagination as needed

        return view('artist.albums.index', compact('albums'));
    }
    public function getAlbumTracks($albumId)
    {
        $album = Album::with('tracks.artist.user')->findOrFail($albumId);
        return response()->json(['tracks' => $album->tracks]);
    }
    public function create()
    {
        return view('artist.albums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'cover_image' => 'required|image|max:5000',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('albums/cover_images', 'public');
        } else {
            $coverImagePath = null;
        }

        $album = Album::create([
            'artist_id' => auth()->user()->artist->id,
            'title' => $request->title,
            'release_date' => $request->release_date,
            'cover_image' => $coverImagePath,
        ]);

        return redirect()->route('artist.albums.show', $album->id)->with('success', 'Album created successfully.');
    }

    public function show($id)
    {
        $album = Album::with('tracks')->findOrFail($id);
        return view('artist.albums.show', compact('album'));
    }

    public function edit($id)
    {
        $album = Album::findOrFail($id);
        return view('artist.albums.edit', compact('album'));
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'cover_image' => 'required|image|max:5000',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }

            $coverImagePath = $request->file('cover_image')->store('albums/cover_images', 'public');
            $album->cover_image = $coverImagePath;
        }

        $album->title = $request->title;
        $album->release_date = $request->release_date;
        $album->save();

        return redirect()->route('artist.albums.show', $album->id)->with('success', 'Album updated successfully.');
    }
}
