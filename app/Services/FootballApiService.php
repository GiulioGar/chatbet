<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Matches;
use Illuminate\Support\Facades\Log; // Importa la facciata Log corretta

class FootballApiService
{
    protected $apiKey;
    protected $apiHost;

    // Array di leghe con i loro ID API
    protected $leagues = [
        135 => 'Serie A',       // Italia
        39  => 'Premier League', // Inghilterra
        140 => 'La Liga',        // Spagna
        78  => 'Bundesliga',     // Germania
        61  => 'Ligue 1'         // Francia
    ];

    public function __construct()
    {
        $this->apiKey = env('FOOTBALL_API_KEY');
        $this->apiHost = env('FOOTBALL_API_HOST');
    }

    public function get($endpoint, $params = [])
    {
        $url = "https://{$this->apiHost}{$endpoint}";

        $response = Http::withHeaders([
            'x-apisports-key' => $this->apiKey,
            'x-rapidapi-host' => $this->apiHost,
        ])->get($url, $params);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function updateAllMatches()
{
    $season = 2024; // Modifica secondo la stagione corrente
    $updatedMatches = 0; // Contatore per il numero di match aggiornati

    foreach ($this->leagues as $leagueId => $leagueName) {
        $response = $this->get('/fixtures', [
            'league' => $leagueId,
            'season' => $season,
        ]);

        if (isset($response['response'])) {
            foreach ($response['response'] as $matchData) {
                $fixtureId = $matchData['fixture']['id'];
                $homeTeamId = $matchData['teams']['home']['id'];
                $awayTeamId = $matchData['teams']['away']['id'];

                $matchDateTime = Carbon::parse($matchData['fixture']['date'])->setTimezone('Europe/Rome');
                $matchDate = $matchDateTime->format('Y-m-d');
                $matchTime = $matchDateTime->format('H:i:s');

                if ($matchTime === '00:00:00' || empty($matchTime)) {
                    $matchTime = '15:00:00';
                }

                // Cerca se la partita esiste già nel database con lo stesso fixtureId
                $existingMatch = Matches::where('fixture_id', $fixtureId)->first();

                if ($existingMatch) {
                    // Se la partita esiste, aggiorna solo i campi necessari
                    $existingMatch->update([
                        'match_date' => $matchDate,
                        'match_time' => $matchTime,
                        'home_score' => $matchData['goals']['home'],
                        'away_score' => $matchData['goals']['away'],
                        'home_ht' => $matchData['score']['halftime']['home'],
                        'away_ht' => $matchData['score']['halftime']['away'],
                        'home_ft' => $matchData['score']['fulltime']['home'],
                        'away_ft' => $matchData['score']['fulltime']['away'],
                        'referee' => $matchData['fixture']['referee']
                    ]);

                    // Incrementa il contatore degli aggiornamenti
                    $updatedMatches++;
                } else {
                    // Se la partita non esiste, crea un nuovo record
                    Matches::create([
                        'fixture_id' => $fixtureId,
                        'league_id' => $leagueId,
                        'home_id' => $homeTeamId,
                        'away_id' => $awayTeamId,
                        'match_date' => $matchDate,
                        'match_time' => $matchTime,
                        'home_score' => $matchData['goals']['home'],
                        'away_score' => $matchData['goals']['away'],
                        'home_ht' => $matchData['score']['halftime']['home'],
                        'away_ht' => $matchData['score']['halftime']['away'],
                        'home_ft' => $matchData['score']['fulltime']['home'],
                        'away_ft' => $matchData['score']['fulltime']['away'],
                        'referee' => $matchData['fixture']['referee']
                    ]);

                    // Incrementa il contatore degli aggiornamenti
                    $updatedMatches++;
                }
            }
        }
    }

    // Ritorna il numero di match aggiornati
    return $updatedMatches;
}



    public function updateMatchStatistics()
    {
        $now = Carbon::now()->setTimezone('Europe/Rome');
        $updatedMatches = 0; // Contatore per il numero di match aggiornati

        $matches = Matches::where(function ($query) use ($now) {
                $query->where('match_date', '<', $now->format('Y-m-d'))
                      ->orWhere(function ($query) use ($now) {
                          $query->where('match_date', '=', $now->format('Y-m-d'))
                                ->where('match_time', '<=', $now->format('H:i:s'));
                      });
            })
            ->whereNull('sog_home') // Controllo che le statistiche non siano già state aggiornate
            ->get();

        foreach ($matches as $match) {
            $fixtureId = $match->fixture_id;

            try {
                $statistics = $this->get('/fixtures/statistics', ['fixture' => $fixtureId]);

                if (isset($statistics['response']) && !empty($statistics['response'])) {
                    $homeStats = [];
                    $awayStats = [];

                    foreach ($statistics['response'] as $teamStats) {
                        if ($teamStats['team']['id'] == $match->home_id) {
                            $homeStats = $teamStats['statistics'];
                        } elseif ($teamStats['team']['id'] == $match->away_id) {
                            $awayStats = $teamStats['statistics'];
                        }
                    }

                    $extractValue = function ($type, $stats) {
                        foreach ($stats as $stat) {
                            if ($stat['type'] == $type) {
                                return $stat['value'];
                            }
                        }
                        return null;
                    };

                    $match->update([
                        'sog_home' => $extractValue('Shots on Goal', $homeStats),
                        'sog_away' => $extractValue('Shots on Goal', $awayStats),
                        'sof_home' => $extractValue('Shots off Goal', $homeStats),
                        'sof_away' => $extractValue('Shots off Goal', $awayStats),
                        'sib_home' => $extractValue('Shots insidebox', $homeStats),
                        'sib_away' => $extractValue('Shots insidebox', $awayStats),
                        'sob_home' => $extractValue('Shots outsidebox', $homeStats),
                        'sob_away' => $extractValue('Shots outsidebox', $awayStats),
                        'tsh_home' => $extractValue('Total Shots', $homeStats),
                        'tsh_away' => $extractValue('Total Shots', $awayStats),
                        'blk_home' => $extractValue('Blocked Shots', $homeStats),
                        'blk_away' => $extractValue('Blocked Shots', $awayStats),
                        'fouls_home' => $extractValue('Fouls', $homeStats),
                        'fouls_away' => $extractValue('Fouls', $awayStats),
                        'corners_home' => $extractValue('Corner Kicks', $homeStats),
                        'corners_away' => $extractValue('Corner Kicks', $awayStats),
                        'offsides_home' => $extractValue('Offsides', $homeStats),
                        'offsides_away' => $extractValue('Offsides', $awayStats),
                        'possession_home' => $extractValue('Ball Possession', $homeStats),
                        'possession_away' => $extractValue('Ball Possession', $awayStats),
                        'yc_home' => $extractValue('Yellow Cards', $homeStats),
                        'yc_away' => $extractValue('Yellow Cards', $awayStats),
                        'rc_home' => $extractValue('Red Cards', $homeStats),
                        'rc_away' => $extractValue('Red Cards', $awayStats),
                        'saves_home' => $extractValue('Goalkeeper Saves', $homeStats),
                        'saves_away' => $extractValue('Goalkeeper Saves', $awayStats),
                        'tpass_home' => $extractValue('Total passes', $homeStats),
                        'tpass_away' => $extractValue('Total passes', $awayStats),
                        'pacc_home' => $extractValue('Passes accurate', $homeStats),
                        'pacc_away' => $extractValue('Passes accurate', $awayStats),
                        'pperc_home' => $extractValue('Passes %', $homeStats),
                        'pperc_away' => $extractValue('Passes %', $awayStats)
                    ]);

                    // Incrementa il contatore se un match è stato aggiornato
                    $updatedMatches++;
                }
            } catch (\Exception $e) {
                // Gestione dell'eccezione in caso di errore durante l'aggiornamento
            }
        }

        // Ritorna il numero di match aggiornati
        return $updatedMatches;
    }



}
