<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cases;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCaseController extends Controller
{
    /**
     * Display a listing of the cases.
     */
    public function index()
    {
        $cases = Cases::with(['artist.user', 'creator'])->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.cases.index', compact('cases'));
    }

    /**
     * Show the form for creating a new case.
     */
    public function create()
    {
        $artists = Artist::with('user')->get();
        return view('admin.cases.create', compact('artists'));
    }

    /**
     * Store a newly created case in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Cases::create([
            'artist_id' => $request->artist_id,
            'created_by' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'open',
        ]);

        return redirect()->route('cases.index')->with('status', 'Case created successfully!');
    }

    /**
     * Display the specified case.
     */
    public function show(Cases $case)
    {
        $case->load(['artist.user', 'creator']);
        return view('admin.cases.show', compact('case'));
    }

    /**
     * Show the form for editing the specified case.
     */
    public function edit(Cases $case)
    {
        $artists = Artist::with('user')->get();
        return view('admin.cases.edit', compact('case', 'artists'));
    }

    /**
     * Update the specified case in storage.
     */
    public function update(Request $request, Cases $case)
    {
        $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,resolved',
            'artist_response' => 'nullable|string',
        ]);

        $case->update([
            'artist_id' => $request->artist_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'artist_response' => $request->artist_response,
        ]);

        return redirect()->route('cases.index')->with('status', 'Case updated successfully!');
    }

    /**
     * Remove the specified case from storage.
     */
    public function destroy(Cases $case)
    {
        $case->delete();
        return redirect()->route('cases.index')->with('status', 'Case deleted successfully!');
    }
}
