<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Matches;
use App\Models\Team;
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
            Log::info("Chiamata API riuscita a {$url}", ['params' => $params]);
            return $response->json();
        }

        Log::error("Errore nella chiamata API a {$url}", ['params' => $params, 'status' => $response->status()]);
        return null;
    }

    public function updateAllMatches()
    {
        $season = 2024; // Modifica secondo la stagione corrente
        $updatedMatches = 0; // Contatore per il numero di match aggiornati

        foreach ($this->leagues as $leagueId => $leagueName) {
            Log::info("Inizio aggiornamento partite per la lega: {$leagueName}");

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
                        Log::info("Aggiornamento partita esistente: fixture ID {$fixtureId}");

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
                    } else {
                        // Se la partita non esiste, crea un nuovo record
                        Log::info("Creazione nuova partita: fixture ID {$fixtureId}");

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
                    }

                    // Incrementa il contatore degli aggiornamenti
                    $updatedMatches++;
                }
            } else {
                Log::warning("Nessuna risposta API per la lega: {$leagueName}");
            }
        }

        Log::info("Aggiornamento completato: {$updatedMatches} partite aggiornate.");
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
            ->where(function ($query) {
                $query->whereNull('sog_home')
                      ->orWhereNull('sog_away')
                      ->orWhereNull('expected_goalsH')
                      ->orWhereNull('goals_preventedH')
                      ->orWhereNull('expected_goalsA')
                      ->orWhereNull('goals_preventedA');
            })
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

                    // Log per visualizzare i dati richiamati
                    Log::info("Statistiche per fixture ID {$fixtureId}", [
                        'homeStats' => $homeStats,
                        'awayStats' => $awayStats
                    ]);

                    // Aggiorna i campi esistenti più i nuovi campi per expected goals e goals prevented
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
                        'pperc_away' => $extractValue('Passes %', $awayStats),
                        // Aggiunta dei nuovi campi
                        'expected_goalsH' => $extractValue('Expected Goals', $homeStats),
                        'goals_preventedH' => $extractValue('Goals Prevented', $homeStats),
                        'expected_goalsA' => $extractValue('Expected Goals', $awayStats),
                        'goals_preventedA' => $extractValue('Goals Prevented', $awayStats),
                    ]);

                    // Incrementa il contatore se un match è stato aggiornato
                    $updatedMatches++;
                } else {
                    Log::warning("Nessuna statistica disponibile per la partita con fixture ID {$fixtureId}");
                }
            } catch (\Exception $e) {
                Log::error("Errore nell'aggiornamento delle statistiche per la partita con fixture ID {$fixtureId}: " . $e->getMessage());
            }
        }

        Log::info("Aggiornamento delle statistiche completato: {$updatedMatches} partite aggiornate.");
        return $updatedMatches;
    }


    public function updateValPresFields()
    {
        // Recupera tutte le partite dalla tabella Matches che sono state disputate
        $matches = Matches::whereNotNull('home_score')
                          ->whereNotNull('away_score')
                          ->get();

        foreach ($matches as $match) {
            // Recupera le squadre di casa e trasferta tramite le relazioni definite nel modello Matches
            $homeTeam = $match->homeTeam;
            $awayTeam = $match->awayTeam;

            if ($homeTeam && $awayTeam) {
                // Recupera i livelli delle squadre
                $homeLevel = $homeTeam->level;
                $awayLevel = $awayTeam->level;

                // Logga i valori dei livelli per debugging
                Log::info("Fixture ID: {$match->fixture_id}, Home Team: {$homeTeam->name}, Level: {$homeLevel}, Away Team: {$awayTeam->name}, Level: {$awayLevel}");

                // Verifica che i livelli non siano nulli o zero
                if (is_numeric($homeLevel) && is_numeric($awayLevel) && $homeLevel > 0 && $awayLevel > 0) {
                    // Calcola i punteggi normalizzati usando la funzione calcolaPunteggio
                    $normalized_scores = $this->calcolaPunteggio(
                        $match->home_score,
                        $match->away_score,
                        (int)$homeLevel,
                        (int)$awayLevel,
                        $match->sog_home,
                        $match->sog_away,
                        $match->tsh_home,
                        $match->tsh_away,
                        $match->possession_home,
                        $match->possession_away,
                        $match->pperc_home,
                        $match->pperc_away,
                        $match->corners_home,
                        $match->corners_away
                    );

                    // Aggiorna i campi val_pres_h e val_pres_a con i valori calcolati
                    $match->update([
                        'val_pres_h' => $normalized_scores['home'],
                        'val_pres_a' => $normalized_scores['away']
                    ]);
                } else {
                    // Logga un avviso se uno dei livelli è pari a zero o non è stato trovato
                    Log::warning("Livelli non validi per la partita con Fixture ID={$match->fixture_id}. Home Level: {$homeLevel}, Away Level: {$awayLevel}");
                }
            } else {
                // Logga un avviso se non riesce a trovare una delle squadre
                Log::warning("Squadra non trovata per la partita con Fixture ID={$match->fixture_id}");
            }
        }

        return "Campi 'val_pres_h' e 'val_pres_a' aggiornati correttamente per tutte le partite disputate.";
    }




    public function calcolaPunteggio(
        $home_score, $away_score,
        $home_level, $away_level,
        $sog_home, $sog_away,
        $tsh_home, $tsh_away,
        $possession_home, $possession_away,
        $pperc_home, $pperc_away,
        $corners_home, $corners_away
    )
    {
        // Funzione helper per convertire percentuali in numeri
        $convertPercentageStringToFloat = function($percentage_string) {
            // Rimuove il simbolo '%' e altri caratteri non numerici
            $number = preg_replace('/[^0-9.]/', '', $percentage_string);
            // Converte la stringa in un numero float
            return floatval($number);
        };

        // Convertire 'possession' e 'pperc' da stringhe a numeri
        $possession_home = $convertPercentageStringToFloat($possession_home);
        $possession_away = $convertPercentageStringToFloat($possession_away);
        $pperc_home = $convertPercentageStringToFloat($pperc_home);
        $pperc_away = $convertPercentageStringToFloat($pperc_away);

        // Verifica che le variabili numeriche siano valide
        $possession_home = is_numeric($possession_home) ? $possession_home : 0;
        $possession_away = is_numeric($possession_away) ? $possession_away : 0;
        $pperc_home = is_numeric($pperc_home) ? $pperc_home : 0;
        $pperc_away = is_numeric($pperc_away) ? $pperc_away : 0;

        // Calcolo del Bonus di Difficoltà (BD)
        $BD_home = ($away_level - $home_level) / 15;
        $BD_away = ($home_level - $away_level) / 15;

        // Calcolo del Punteggio Base (PB)
        $PB_home = 50 + $BD_home;
        $PB_away = 50 + $BD_away;

        // Calcolo del Fattore Gol (FG)
        $FG_home = ($home_score - $away_score) * 10;
        $FG_away = ($away_score - $home_score) * 10;

        // Calcolo del Punteggio Principale (PP)
        $PP_home = $PB_home + $FG_home;
        $PP_away = $PB_away + $FG_away;

        // Calcolo delle somme totali per le statistiche
        $total_sog = $sog_home + $sog_away;
        $total_tsh = $tsh_home + $tsh_away;
        $total_corner = $corners_home + $corners_away;
        $total_possession = $possession_home + $possession_away;
        $total_pperc = $pperc_home + $pperc_away;

        // Evita divisioni per zero
        $total_sog = $total_sog ?: 1;
        $total_tsh = $total_tsh ?: 1;
        $total_corner = $total_corner ?: 1;
        $total_possession = $total_possession ?: 1;
        $total_pperc = $total_pperc ?: 1;

        // Calcolo delle percentuali per la squadra di casa
        $sog_perc_home = $sog_home / $total_sog;
        $tsh_perc_home = $tsh_home / $total_tsh;
        $corner_perc_home = $corners_home / $total_corner;
        $possession_perc_home = $possession_home / $total_possession;
        $pperc_perc_home = $pperc_home / $total_pperc;

        // Calcolo delle percentuali per la squadra in trasferta
        $sog_perc_away = $sog_away / $total_sog;
        $tsh_perc_away = $tsh_away / $total_tsh;
        $corner_perc_away = $corners_away / $total_corner;
        $possession_perc_away = $possession_away / $total_possession;
        $pperc_perc_away = $pperc_away / $total_pperc;

        // Pesi assegnati alle variabili
        $weights = [
            'sog' => 0.25,
            'tsh' => 0.25,
            'possession' => 0.20,
            'pperc' => 0.15,
            'corner' => 0.15,
        ];

        // Calcolo del Punteggio Statistico (PS) per la squadra di casa
        $PS_home = 20 * (
            ($sog_perc_home * $weights['sog']) +
            ($tsh_perc_home * $weights['tsh']) +
            ($possession_perc_home * $weights['possession']) +
            ($pperc_perc_home * $weights['pperc']) +
            ($corner_perc_home * $weights['corner'])
        );

        // Calcolo del Punteggio Statistico (PS) per la squadra in trasferta
        $PS_away = 20 * (
            ($sog_perc_away * $weights['sog']) +
            ($tsh_perc_away * $weights['tsh']) +
            ($possession_perc_away * $weights['possession']) +
            ($pperc_perc_away * $weights['pperc']) +
            ($corner_perc_away * $weights['corner'])
        );

        // Calcolo del Punteggio Finale (PF)
        $PF_home = $PP_home + $PS_home;
        $PF_away = $PP_away + $PS_away;

        // Limita i punteggi tra 1 e 100
        $PF_home = max(1, min($PF_home, 100));
        $PF_away = max(1, min($PF_away, 100));

        // Arrotonda i punteggi a due decimali
        $PF_home = round($PF_home, 2);
        $PF_away = round($PF_away, 2);

        // Restituisce i punteggi finali in un array
        return [
            'home' => $PF_home,
            'away' => $PF_away
        ];
    }








    }


