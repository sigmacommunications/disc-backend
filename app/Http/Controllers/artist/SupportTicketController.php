<?php

namespace App\Http\Controllers\artist;

use App\Http\Controllers\Controller;
use App\Models\SupportResponse;
use App\Models\SupportTicket;
use Auth;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $tickets = SupportTicket::with('artist')->latest()->paginate(10);
        } else {
            $artist = $user->artist;
            $tickets = SupportTicket::where('artist_id', $artist->id)->with('responses')->latest()->paginate(10);
        }

        return view('artist.support.index', compact('tickets'));
    }

    // Show the form to create a new support ticket
    public function create()
    {
        return view('artist.support.create');
    }

    // Store a new support ticket
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $artist = Auth::user()->artist;

        SupportTicket::create([
            'artist_id' => $artist->id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('artist.support.index')->with('success', 'Support ticket created successfully.');
    }

    // Display a specific support ticket
    public function show($id)
    {
        $userid = Auth::user();
        $ticket = SupportTicket::where('artist_id', $userid->artist->id)
            ->where('id', $id)
            ->with('responses.user')
            ->first();

        if ($ticket) {
            $ticket->responses()->where('user_id', '!=', $userid->id)->update(['is_read' => true]);
            return view('artist.support.show', compact('ticket'));
        }
        return redirect()->back()->with('error', 'You Do Not Have Permission To View This Page.');
    }

    // Add a response to a support ticket
    public function respond(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if ($ticket->status === 'closed') {
            return redirect()->back()->with('error', 'You cannot respond to a closed ticket.');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        SupportResponse::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        if ($ticket->status !== 'closed') {
            $ticket->update(['status' => 'open']);
        }

        return redirect()->route('artist.support.show', $ticket->id)->with('success', 'Response added successfully.');
    }

    // Close a support ticket
    public function close($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $ticket->update(['status' => 'closed']);

        return redirect()->route('artist.support.show', $ticket->id)->with('success', 'Ticket closed successfully.');
    }
}
