<?php

namespace App\Http\Controllers\artist;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use Illuminate\Http\Request;

class ArtistCaseController extends Controller
{
    public function index()
    {
        $artist = auth()->user()->artist;
        $cases = Cases::where('artist_id', $artist->id)->with('creator')->orderBy('updated_at','desc')->paginate(10);
        return view('artist.cases.index', compact('cases'));
    }

    /**
     * Display the specified case.
     */
    public function show(Cases $case)
    {
        $this->authorizeArtistCase($case);
        $case->load('creator');

        return view('artist.cases.show', compact('case'));
    }

    /**
     * Handle the artist's response to a case.
     */
    public function respond(Request $request, Cases $case)
    {
        $this->authorizeArtistCase($case);

        $request->validate([
            'artist_response' => 'required|string',
        ]);

        $case->artist_response = $request->artist_response;
        $case->responded_at = now();
        if ($case->status == 'open') {
            $case->status = 'in_progress';
        }
        $case->save();

        return redirect()->route('artist.cases.show', $case->id)->with('status', 'Response submitted successfully!');
    }

    /**
     * Ensure the authenticated artist owns the case.
     */
    protected function authorizeArtistCase(Cases $case)
    {
        $artist = auth()->user()->artist;
        if ($case->artist_id != $artist->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
