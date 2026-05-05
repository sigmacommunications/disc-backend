<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Contract;
use Illuminate\Http\Request;
use Storage;

class AdminContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('artist')->paginate(10);
        return view('admin.contracts.index', compact('contracts'));
    }
    public function create()
    {
        $artists = Artist::all();
        return view('admin.contracts.create', compact('artists'));
    }

    // Store the contract details
    public function store(Request $request)
    {
        $request->validate([
            'contract_name' => 'required|string',
            'artist_id' => 'required|exists:artists,id',
            'contract_details' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'contract_file' => 'nullable|file|mimes:pdf,docx,jpeg,jpg,png'
        ]);

        // Store contract file if present
        $filePath = null;
        if ($request->hasFile('contract_file')) {
            $filePath = $request->file('contract_file')->store('contracts', 'public');
        }

        // Create the contract
        Contract::create([
            'artist_id' => $request->artist_id,
            'contract_name' => $request->contract_name,
            'contract_details' => $request->contract_details,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'file_path' => $filePath,
        ]);

        return redirect()->route('contracts.index')->with('success', 'Contract added successfully!');
    }

    // View contracts for a specific artist
    public function show(Artist $artist)
    {
        $contracts = $artist->contracts;
        return view('admin.contracts.index', compact('artist', 'contracts'));
    }
    public function edit(Contract $contract)
    {
        $artists = Artist::all();
        return view('admin.contracts.edit', compact('contract','artists'));
    }
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'contract_name' => 'required|string',
            'contract_details' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'contract_file' => 'nullable|file|mimes:pdf,docx,jpeg,jpg,png'
        ]);

        $contract->contract_name = $request->contract_name;
        $contract->artist_id = $request->artist_id;
        $contract->contract_details = $request->contract_details;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;

        // If a new file is uploaded, replace the old one
        if ($request->hasFile('contract_file')) {
            if ($contract->file_path) {
                Storage::disk('public')->delete($contract->file_path);
            }
            $contract->file_path = $request->file('contract_file')->store('contracts', 'public');
        }

        $contract->save();

        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully!');
    }

    // Delete a contract
    public function destroy(Contract $contract)
    {
        // Delete the contract file if it exists
        if ($contract->file_path) {
            Storage::disk('public')->delete($contract->file_path);
        }

        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully!');
    }
}
