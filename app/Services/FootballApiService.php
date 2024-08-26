<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Matches;

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

        foreach ($this->leagues as $leagueId => $leagueName) {
            $response = $this->get('/fixtures', [
                'league' => $leagueId,
                'season' => $season,
            ]);

            if (isset($response['response'])) {
                foreach ($response['response'] as $matchData) {
                    // Estrai i dati delle squadre usando gli ID
                    $homeTeamId = $matchData['teams']['home']['id'];
                    $awayTeamId = $matchData['teams']['away']['id'];

                    // Converti la data
                    $matchDate = Carbon::parse($matchData['fixture']['date'])->format('Y-m-d');

                    // Estrai l'ora o imposta il valore predefinito di '15:00'
                    $matchTime = Carbon::parse($matchData['fixture']['date'])->format('H:i:s');
                    if ($matchTime === '00:00:00') {
                        $matchTime = '15:00:00';
                    }

                    // Inserisci o aggiorna la partita utilizzando gli ID delle squadre e delle leghe
                    Matches::updateOrCreate(
                        [
                            'league_id' => $leagueId,   // Usa l'ID della lega
                            'home_id' => $homeTeamId,   // Usa l'ID della squadra di casa
                            'away_id' => $awayTeamId,   // Usa l'ID della squadra ospite
                            'match_date' => $matchDate,
                        ],
                        [
                            'match_time' => $matchTime,
                            'home_score' => $matchData['goals']['home'],
                            'away_score' => $matchData['goals']['away'],
                            'home_ht' => $matchData['score']['halftime']['home'],
                            'away_ht' => $matchData['score']['halftime']['away'],
                            'home_ft' => $matchData['score']['fulltime']['home'],
                            'away_ft' => $matchData['score']['fulltime']['away'],
                            'referee' => $matchData['fixture']['referee']
                        ]
                    );
                }
            }
        }
    }
}
