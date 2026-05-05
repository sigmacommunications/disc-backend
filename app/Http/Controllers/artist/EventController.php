<?php

namespace App\Http\Controllers\artist;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Storage;

class EventController extends Controller
{
    public function index()
    {
        // Retrieve events for the authenticated artist, paginated
        $events = Event::where('artist_id', auth()->user()->artist->id)
            ->orderBy('event_date', 'asc')
            ->paginate(10); // Adjust pagination as needed

        return view('artist.events.index', compact('events'));
    }
    public function create()
    {
        return view('artist.events.create');
    }

    public function store(Request $request)
	{
		$request->validate([
			'title' => 'required|string|max:255',
			'event_date' => 'required|date',
			'ticket_link' => 'nullable|url',
			'promotional_details' => 'nullable|string',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			// Add validation for location fields
			'latitude' => 'required|numeric|between:-90,90',
			'longitude' => 'required|numeric|between:-180,180',
			'location_search' => 'required|string|max:500',
		]);

		$imagePath = null;
		if ($request->hasFile('image')) {
			$imagePath = $request->file('image')->store('events', 'public');
		}

		Event::create([
			'artist_id' => auth()->user()->artist->id,
			'title' => $request->title,
			'event_date' => $request->event_date,
			'ticket_link' => $request->ticket_link,
			'promotional_details' => $request->promotional_details,
			'image' => $imagePath,
			// Add location fields
			'latitude' => $request->latitude,
			'longitude' => $request->longitude,
			'location_address' => $request->location_search,
		]);

		return redirect()->route('artist.dashboard')->with('success', 'Event added successfully.');
	}


    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('artist.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
	{
		$event = Event::findOrFail($id);

		$request->validate([
			'title' => 'required|string|max:255',
			'event_date' => 'required|date',
			'ticket_link' => 'nullable|url',
			'promotional_details' => 'nullable|string',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			// Add validation for location fields
			'latitude' => 'required|numeric|between:-90,90',
			'longitude' => 'required|numeric|between:-180,180',
			'location_search' => 'required|string|max:500',
		]);

		// Handle image upload
		if ($request->hasFile('image')) {
			// Delete old image if it exists
			if ($event->image) {
				Storage::delete('public/' . $event->image);
			}

			// Store the new image
			$imagePath = $request->file('image')->store('events', 'public');
			$event->image = $imagePath;
		}

		$event->title = $request->title;
		$event->event_date = $request->event_date;
		$event->ticket_link = $request->ticket_link;
		$event->promotional_details = $request->promotional_details;

		// Add location fields
		$event->latitude = $request->latitude;
		$event->longitude = $request->longitude;
		$event->location_address = $request->location_search;

		$event->save();

		return redirect()->route('artist.dashboard')->with('success', 'Event updated successfully.');
	}


    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully.');
    }
}
