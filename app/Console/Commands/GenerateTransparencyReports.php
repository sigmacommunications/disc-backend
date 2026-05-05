<?php

namespace App\Console\Commands;

use App\Models\Artist;
use App\Notifications\NewTransparencyReport;
use Illuminate\Console\Command;

class GenerateTransparencyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:generate-transparency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reportDate = now()->subMonth()->format('F Y');

        // Fetch all artists
        $artists = Artist::with([
            'user',
            'royalties' => function ($query) use ($reportDate) {
                $query->whereYear('earned_at', now()->subMonth()->year)
                    ->whereMonth('earned_at', now()->subMonth()->month);
            }
        ])->get();

        foreach ($artists as $artist) {

            $artist->user->notify(new NewTransparencyReport($reportDate));

        }
    }
}
