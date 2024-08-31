<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Support\Facades\Log;

class MatchController extends Controller
{
    public function showStatistics($homeTeam, $awayTeam)
    {
        // Recupera l'ID delle squadre dai nomi
        $homeTeamData = Team::where('name', $homeTeam)->first();
        $awayTeamData = Team::where('name', $awayTeam)->first();

        if (!$homeTeamData || !$awayTeamData) {
            // Gestione degli errori per squadre non valide
            Log::error("Una o entrambe le squadre non sono state trovate: $homeTeam, $awayTeam");
            return back()->with('error', 'Squadre non trovate. Riprova con nomi validi.');
        }

        // Recupera la partita tra le due squadre
        $match = Matches::where('home_id', $homeTeamData->team_id)
                        ->where('away_id', $awayTeamData->team_id)
                        ->orWhere(function($query) use ($homeTeamData, $awayTeamData) {
                            $query->where('home_id', $awayTeamData->team_id)
                                  ->where('away_id', $homeTeamData->team_id);
                        })
                        ->first();

        if (!$match) {
            // Gestione degli errori in caso di nessuna partita trovata
            Log::error("Nessuna partita trovata tra $homeTeam e $awayTeam");
            return back()->with('error', 'Nessuna partita trovata tra le squadre specificate.');
        }

        // Passa le statistiche della partita alla vista
        return view('matches.statMatch', [
            'match' => $match,
            'homeTeam' => $homeTeamData,
            'awayTeam' => $awayTeamData
        ]);
    }
}
