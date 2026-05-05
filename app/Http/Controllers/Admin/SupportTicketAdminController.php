<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportResponse;
use App\Models\SupportTicket;
use App\Notifications\SupportTicketResponded;
use Auth;
use Illuminate\Http\Request;

class SupportTicketAdminController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('artist.user')->latest()->paginate(10);
        return view('admin.support.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = SupportTicket::with('responses.user', 'artist.user')->findOrFail($id);
        $ticket->responses()->where('user_id', '!=', Auth::id())->update(['is_read' => true]);

        return view('admin.support.show', compact('ticket'));
    }

    public function respond(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $request->validate([
            'message' => 'required|string',
        ]);

        $response = SupportResponse::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Update ticket status if necessary
        if ($ticket->status !== 'closed') {
            $ticket->update(['status' => 'open']);
        }

        // Notify the artist
        $ticket->artist->user->notify(new SupportTicketResponded($ticket));

        return redirect()->route('support.show', $ticket->id)->with('success', 'Response added successfully.');
    }

    public function close($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $ticket->update(['status' => 'closed']);

        return redirect()->route('support.show', $ticket->id)->with('success', 'Ticket closed successfully.');
    }
}
