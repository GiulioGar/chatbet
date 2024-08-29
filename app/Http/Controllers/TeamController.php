<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamStatisticsService; // Importa il servizio
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    protected $teamStatsService;

    public function __construct(TeamStatisticsService $teamStatsService)
    {
        $this->teamStatsService = $teamStatsService;
    }

    public function updateTeams(Request $request)
    {
        try {
            $this->teamStatsService->updateTeamStatistics();

            return redirect()->back()->with('success', 'Statistiche delle squadre aggiornate con successo.');
        } catch (\Exception $e) {
            Log::error('Errore durante l\'aggiornamento delle statistiche delle squadre: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Si è verificato un errore durante l\'aggiornamento delle statistiche delle squadre.');
        }
    }
}
