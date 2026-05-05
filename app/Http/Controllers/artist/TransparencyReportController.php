<?php

namespace App\Http\Controllers\artist;

use App\Http\Controllers\Controller;
use App\Models\Royalty;
use Auth;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class TransparencyReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $artist = $user->artist;
        $royalties = Royalty::where('artist_id', $artist->id)->orderBy('earned_at', 'desc')->get();

        $totalEarnings = $royalties->sum('amount');

        return view('artist.reports.index', compact('royalties', 'totalEarnings'));
    }

    // Download the transparency report as PDF
    public function download()
    {
        $user = Auth::user();
        $artist = $user->artist;
        $royalties = Royalty::where('artist_id', $artist->id)->orderBy('earned_at', 'desc')->get();

        $totalEarnings = $royalties->sum('amount');

        $pdf = Pdf::view('artist.reports.pdf', compact('royalties', 'totalEarnings', 'artist'));

        return $pdf->download('transparency_report.pdf');
    }
}
