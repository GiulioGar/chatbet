@extends('layouts.app')

@section('content')
<link href="{{ asset('css/todayMatches.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">




<div class="container main-content">
    <div class="row tableMatches">
        <div class="col-md-12">

            <!-- Menu per le date -->
            <div class="date-menu">
                <ul class="date-selector">
                    @for ($i = 0; $i <= 8; $i++)
                        @php
                            $date = \Carbon\Carbon::today()->addDays($i);
                        @endphp
                        <li class="{{ $selectedDate->isSameDay($date) ? 'active' : '' }}">
                            <a href="{{ route('match.todayMatches', $date->format('Y-m-d')) }}">
                                {{ $date->translatedFormat('D d M') }} <!-- Mostra la data come "Gio 16 OTT" -->
                            </a>
                        </li>
                    @endfor
                </ul>
            </div>

            <!-- Contenitore per le partite -->
            <div class="matches-container">
                @if($matches->isEmpty())
                    <p class="no-matches-message">Nessuna partita in programma</p>
                @else
                    <!-- Sezione Filtri -->
                    <div class="filters">
                        <div class="filter-group">
                            <button class="filter-button active" data-section="risultati">Risultati</button>
                            <button class="filter-button" data-section="gol">Gol</button>
                            <button class="filter-button" data-section="corner">Corner</button>
                            <button class="filter-button" data-section="tiri">Tiri</button>
                            <button class="filter-button" data-section="sanzioni">Sanzioni</button>
                            <button class="filter-button" data-section="tempo1">Primo tempo</button>
                        </div>
                    </div>

                    <table class="matches-table">
                        <thead>
                            <tr>
                                <!-- Colonne Sempre Visibili -->
                                <th>Ora</th>
                                <th>Campionato</th>
                                <th></th>
                                <th></th>
                                <th class="col-fascia"></th>
                                <th></th>
                                <th class="col-fascia"></th>
                                <th></th>

                                <!-- Sezioni con Classi Specifiche -->
                                <!-- Risultati -->
                                <th class="col-risultati">1</th>
                                <th class="col-risultati">X</th>
                                <th class="col-risultati">2</th>

                                <!-- Gol -->
                                <th class="col-gol">O 1.5</th>
                                <th class="col-gol">O 2.5</th>
                                <th class="col-gol">O 3.5</th>
                                <th class="col-gol">G/G</th>

                                <!-- Corner -->
                                <th class="col-corner">Corner</th>
                                <th class="col-corner">Casa</th>
                                <th class="col-corner">Fuori</th>

                                <!-- Tiri Totali -->
                                <th class="col-tiri">Tiri Tot</th>
                                <th class="col-tiri">Casa</th>
                                <th class="col-tiri">Fuori</th>

                                <!-- Tiri in Porta -->
                                <th class="col-tiri">In Porta</th>
                                <th class="col-tiri">Casa</th>
                                <th class="col-tiri">Fuori</th>

                                <!-- Sanzioni -->
                                <th class="col-sanzioni">Cartellini</th>
                                <th class="col-sanzioni">Casa</th>
                                <th class="col-sanzioni">Fuori F</th>
                                <th class="col-sanzioni">Falli</th>
                                <th class="col-sanzioni">Casa</th>
                                <th class="col-sanzioni">Fuori</th>

                                 <!-- 1 tempo -->
                                 <th class="col-tempo1">O 0.5</th>
                                 <th class="col-tempo1">O 1.5</th>
                                 <th class="col-tempo1">O 2.5</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($matches as $match)

                            @php
                            // Tiri singoli
                            $tiriTotSing = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->h_total_shots + $match->homeTeam->a_total_shots) / $match->homeTeam->t_played, 2) : 0;
                            $tiriTotSingH = $match->homeTeam->h_played > 0 ? round($match->homeTeam->h_total_shots / $match->homeTeam->h_played, 2) : 0;
                            $tiriTotSingA = $match->homeTeam->a_played > 0 ? round($match->homeTeam->a_total_shots / $match->homeTeam->a_played, 2) : 0;
                            $tiriGolSing = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->h_shots_on_goal + $match->homeTeam->a_shots_on_goal) / $match->homeTeam->t_played, 2) : 0;
                            $tiriGolSingH = $match->homeTeam->h_played > 0 ? round($match->homeTeam->h_shots_on_goal / $match->homeTeam->h_played, 2) : 0;
                            $tiriGolSingA = $match->homeTeam->a_played > 0 ? round($match->homeTeam->a_shots_on_goal / $match->homeTeam->a_played, 2) : 0;

                            $tiriSubTotSing = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->tsh_conc_h + $match->homeTeam->tsh_conc_a) / $match->homeTeam->t_played, 2) : 0;
                            $tiriSubTotSingH = $match->homeTeam->h_played > 0 ? round($match->homeTeam->tsh_conc_h / $match->homeTeam->h_played, 2) : 0;
                            $tiriSubTotSingA = $match->homeTeam->a_played > 0 ? round($match->homeTeam->tsh_conc_a / $match->homeTeam->a_played, 2) : 0;

                            $tiriSubGolSing = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->sog_conc_h + $match->homeTeam->sog_conc_a) / $match->homeTeam->t_played, 2) : 0;
                            $tiriSubGolSingH = $match->homeTeam->h_played > 0 ? round($match->homeTeam->sog_conc_h / $match->homeTeam->h_played, 2) : 0;
                            $tiriSubGolSingA = $match->homeTeam->a_played > 0 ? round($match->homeTeam->sog_conc_a / $match->homeTeam->a_played, 2) : 0;

                            // Tiri a partita
                            $tiriTotMatch = $tiriTotSing + $tiriSubTotSing;
                            $tiriTotMatchH = $tiriTotSingH + $tiriSubTotSingH;
                            $tiriTotMatchA = $tiriTotSingA + $tiriSubTotSingA;

                            $tiriGolMatch = $tiriGolSing + $tiriSubGolSing;
                            $tiriGolMatchH = $tiriGolSingH + $tiriSubGolSingH;
                            $tiriGolMatchA = $tiriGolSingA + $tiriSubGolSingA;

                            // Tiri singoli squadra ospite
                            $AtiriTotSing = $match->awayTeam->t_played > 0 ? round(($match->awayTeam->h_total_shots + $match->awayTeam->a_total_shots) / $match->awayTeam->t_played, 2) : 0;
                            $AtiriTotSingH = $match->awayTeam->h_played > 0 ? round($match->awayTeam->h_total_shots / $match->awayTeam->h_played, 2) : 0;
                            $AtiriTotSingA = $match->awayTeam->a_played > 0 ? round($match->awayTeam->a_total_shots / $match->awayTeam->a_played, 2) : 0;
                            $AtiriGolSing = $match->awayTeam->t_played > 0 ? round(($match->awayTeam->h_shots_on_goal + $match->awayTeam->a_shots_on_goal) / $match->awayTeam->t_played, 2) : 0;
                            $AtiriGolSingH = $match->awayTeam->h_played > 0 ? round($match->awayTeam->h_shots_on_goal / $match->awayTeam->h_played, 2) : 0;
                            $AtiriGolSingA = $match->awayTeam->a_played > 0 ? round($match->awayTeam->a_shots_on_goal / $match->awayTeam->a_played, 2) : 0;

                            $AtiriSubTotSing = $match->awayTeam->t_played > 0 ? round(($match->awayTeam->tsh_conc_h + $match->awayTeam->tsh_conc_a) / $match->awayTeam->t_played, 2) : 0;
                            $AtiriSubTotSingH = $match->awayTeam->h_played > 0 ? round($match->awayTeam->tsh_conc_h / $match->awayTeam->h_played, 2) : 0;
                            $AtiriSubTotSingA = $match->awayTeam->a_played > 0 ? round($match->awayTeam->tsh_conc_a / $match->awayTeam->a_played, 2) : 0;

                            $AtiriSubGolSing = $match->awayTeam->t_played > 0 ? round(($match->awayTeam->sog_conc_h + $match->awayTeam->sog_conc_a) / $match->awayTeam->t_played, 2) : 0;
                            $AtiriSubGolSingH = $match->awayTeam->h_played > 0 ? round($match->awayTeam->sog_conc_h / $match->awayTeam->h_played, 2) : 0;
                            $AtiriSubGolSingA = $match->awayTeam->a_played > 0 ? round($match->awayTeam->sog_conc_a / $match->awayTeam->a_played, 2) : 0;

                            // Tiri a partita squadra ospite
                            $AtiriTotMatch = $AtiriTotSing + $AtiriSubTotSing;
                            $AtiriTotMatchH = $AtiriTotSingH + $AtiriSubTotSingH;
                            $AtiriTotMatchA = $AtiriTotSingA + $AtiriSubTotSingA;

                            $AtiriGolMatch = $AtiriGolSing + $AtiriSubGolSing;
                            $AtiriGolMatchH = $AtiriGolSingH + $AtiriSubGolSingH;
                            $AtiriGolMatchA = $AtiriGolSingA + $AtiriSubGolSingA;

                            // Calcolo dei tiri totali per la squadra di casa
                            $mediaTiriTotaliCasa = (0.65 * $tiriTotMatch) + (0.35 * $tiriTotMatchH);
                            $mediaTiriTotaliCasaS = (0.65 * $tiriTotSing) + (0.35 * $tiriTotSingH);
                            $mediaTiriTotaliCasaS = round($mediaTiriTotaliCasaS, 1);

                            // Calcolo dei tiri totali per la squadra fuori
                            $mediaTiriTotaliFuori = (0.65 * $AtiriTotMatch) + (0.35 * $AtiriTotMatchA);
                            $mediaTiriTotaliFuoriS = (0.65 * $AtiriTotSing) + (0.35 * $AtiriTotSingA);
                            $mediaTiriTotaliFuoriS = round($mediaTiriTotaliFuoriS, 1);

                            // Calcolo della media ponderata totale per i tiri totali nel match
                            $mediaTiriTotaliMatch = ($mediaTiriTotaliCasa + $mediaTiriTotaliFuori) / 2;
                            $mediaTiriTotaliMatch = round($mediaTiriTotaliMatch, 1);

                            // Calcolo dei tiri in porta per la squadra di casa
                            $mediaTiriInPortaCasa = (0.65 * $tiriGolMatch) + (0.35 * $tiriGolMatchH);
                            $mediaTiriInPortaCasaS = (0.65 * $tiriGolSing) + (0.35 * $tiriGolSingH);
                            $mediaTiriInPortaCasaS = round($mediaTiriInPortaCasaS, 1);

                            // Calcolo dei tiri in porta per la squadra fuori
                            $mediaTiriInPortaFuori = (0.65 * $AtiriGolMatch) + (0.35 * $AtiriGolMatchA);
                            $mediaTiriInPortaFuoriS = (0.65 * $AtiriGolSing) + (0.35 * $AtiriGolSingA);
                            $mediaTiriInPortaFuoriS = round($mediaTiriInPortaFuoriS, 1);

                            // Calcolo della media ponderata totale per i tiri in porta nel match
                            $mediaTiriInPortaMatch = ($mediaTiriInPortaCasa + $mediaTiriInPortaFuori) / 2;
                            $mediaTiriInPortaMatch = round($mediaTiriInPortaMatch, 1);

                            // Pesi per la media ponderata
                            $w1 = 0.35;
                            $w2 = 0.65;

                            // Calcoli per la squadra di casa
                            // Cartellini
                            $homeCardsReceivedTotal = $match->homeTeam->t_yellow_cards + (2 * $match->homeTeam->t_red_cards);
                            $homeCardsReceivedHome = $match->homeTeam->h_yellow_cards + (2 * $match->homeTeam->h_red_cards);
                            $homeCardsReceivedTotalPerMatch = $match->homeTeam->t_played > 0 ? $homeCardsReceivedTotal / $match->homeTeam->t_played : 0;
                            $homeCardsReceivedHomePerMatch = $match->homeTeam->h_played > 0 ? $homeCardsReceivedHome / $match->homeTeam->h_played : 0;
                            $homeCardsReceivedAverage = ($homeCardsReceivedTotalPerMatch * $w1) + ($homeCardsReceivedHomePerMatch * $w2);

                            $homeCardsConcededTotal = ($match->homeTeam->yc_conc_h + $match->homeTeam->yc_conc_a) + (2 * ($match->homeTeam->rc_conc_h + $match->homeTeam->rc_conc_a));
                            $homeCardsConcededHome = $match->homeTeam->yc_conc_h + (2 * $match->homeTeam->rc_conc_h);
                            $homeCardsConcededTotalPerMatch = $match->homeTeam->t_played > 0 ? $homeCardsConcededTotal / $match->homeTeam->t_played : 0;
                            $homeCardsConcededHomePerMatch = $match->homeTeam->h_played > 0 ? $homeCardsConcededHome / $match->homeTeam->h_played : 0;
                            $homeCardsConcededAverage = ($homeCardsConcededTotalPerMatch * $w1) + ($homeCardsConcededHomePerMatch * $w2);

                            $homeTotalCardsPerMatch = $homeCardsReceivedAverage + $homeCardsConcededAverage;

                            // Falli
                            $homeFoulsCommittedTotalPerMatch = $match->homeTeam->t_played > 0 ? $match->homeTeam->t_fouls / $match->homeTeam->t_played : 0;
                            $homeFoulsCommittedHomePerMatch = $match->homeTeam->h_played > 0 ? $match->homeTeam->h_fouls / $match->homeTeam->h_played : 0;
                            $homeFoulsCommittedAverage = ($homeFoulsCommittedTotalPerMatch * $w1) + ($homeFoulsCommittedHomePerMatch * $w2);

                            $homeFoulsConcededTotal = $match->homeTeam->fouls_conc_h + $match->homeTeam->fouls_conc_a;
                            $homeFoulsConcededTotalPerMatch = $match->homeTeam->t_played > 0 ? $homeFoulsConcededTotal / $match->homeTeam->t_played : 0;
                            $homeFoulsConcededHomePerMatch = $match->homeTeam->h_played > 0 ? $match->homeTeam->fouls_conc_h / $match->homeTeam->h_played : 0;
                            $homeFoulsConcededAverage = ($homeFoulsConcededTotalPerMatch * $w1) + ($homeFoulsConcededHomePerMatch * $w2);

                            $homeTotalFoulsPerMatch = $homeFoulsCommittedAverage + $homeFoulsConcededAverage;

                            $homeTotalCardsPerMatch = round($homeTotalCardsPerMatch, 2);
                            $homeTotalFoulsPerMatch = round($homeTotalFoulsPerMatch, 2);

                            // Calcoli per la squadra ospite
                            // Cartellini
                            $awayCardsReceivedTotal = $match->awayTeam->t_yellow_cards + (2 * $match->awayTeam->t_red_cards);
                            $awayCardsReceivedAway = $match->awayTeam->a_yellow_cards + (2 * $match->awayTeam->a_red_cards);
                            $awayCardsReceivedTotalPerMatch = $match->awayTeam->t_played > 0 ? $awayCardsReceivedTotal / $match->awayTeam->t_played : 0;
                            $awayCardsReceivedAwayPerMatch = $match->awayTeam->a_played > 0 ? $awayCardsReceivedAway / $match->awayTeam->a_played : 0;
                            $awayCardsReceivedAverage = ($awayCardsReceivedTotalPerMatch * $w1) + ($awayCardsReceivedAwayPerMatch * $w2);

                            $awayCardsConcededTotal = ($match->awayTeam->yc_conc_h + $match->awayTeam->yc_conc_a) + (2 * ($match->awayTeam->rc_conc_h + $match->awayTeam->rc_conc_a));
                            $awayCardsConcededAway = $match->awayTeam->yc_conc_a + (2 * $match->awayTeam->rc_conc_a);
                            $awayCardsConcededTotalPerMatch = $match->awayTeam->t_played > 0 ? $awayCardsConcededTotal / $match->awayTeam->t_played : 0;
                            $awayCardsConcededAwayPerMatch = $match->awayTeam->a_played > 0 ? $awayCardsConcededAway / $match->awayTeam->a_played : 0;
                            $awayCardsConcededAverage = ($awayCardsConcededTotalPerMatch * $w1) + ($awayCardsConcededAwayPerMatch * $w2);

                            $awayTotalCardsPerMatch = $awayCardsReceivedAverage + $awayCardsConcededAverage;

                            // Falli
                            $awayFoulsCommittedTotalPerMatch = $match->awayTeam->t_played > 0 ? $match->awayTeam->t_fouls / $match->awayTeam->t_played : 0;
                            $awayFoulsCommittedAwayPerMatch = $match->awayTeam->a_played > 0 ? $match->awayTeam->a_fouls / $match->awayTeam->a_played : 0;
                            $awayFoulsCommittedAverage = ($awayFoulsCommittedTotalPerMatch * $w1) + ($awayFoulsCommittedAwayPerMatch * $w2);

                            $awayFoulsConcededTotal = $match->awayTeam->fouls_conc_h + $match->awayTeam->fouls_conc_a;
                            $awayFoulsConcededTotalPerMatch = $match->awayTeam->t_played > 0 ? $awayFoulsConcededTotal / $match->awayTeam->t_played : 0;
                            $awayFoulsConcededAwayPerMatch = $match->awayTeam->a_played > 0 ? $match->awayTeam->fouls_conc_a / $match->awayTeam->a_played : 0;
                            $awayFoulsConcededAverage = ($awayFoulsConcededTotalPerMatch * $w1) + ($awayFoulsConcededAwayPerMatch * $w2);

                            $awayTotalFoulsPerMatch = $awayFoulsCommittedAverage + $awayFoulsConcededAverage;

                            $awayTotalCardsPerMatch = round($awayTotalCardsPerMatch, 2);
                            $awayTotalFoulsPerMatch = round($awayTotalFoulsPerMatch, 2);

                            // Totali attesi per la partita
                            $totalCardsMatch = round(($homeTotalCardsPerMatch + $awayTotalCardsPerMatch) / 2, 2);
                            $totalFoulsMatch = round(($homeTotalFoulsPerMatch + $awayTotalFoulsPerMatch) / 2, 2);

                            // Partite giocate
                            $homeTotalMatches = $match->homeTeam->t_played;
                            $homeHomeMatches = $match->homeTeam->h_played;
                            $homeAwayMatches = $match->homeTeam->a_played;

                            // Medie per partita - Statistiche della squadra
                            $homeAverageFoulsTotal = $homeTotalMatches > 0 ? $match->homeTeam->t_fouls / $homeTotalMatches : 0;
                            $homeAverageFoulsHome = $homeHomeMatches > 0 ? $match->homeTeam->h_fouls / $homeHomeMatches : 0;
                            $homeAverageFoulsAway = $homeAwayMatches > 0 ? $match->homeTeam->a_fouls / $homeAwayMatches : 0;

                            $homeAverageYellowCardsTotal = $homeTotalMatches > 0 ? $match->homeTeam->t_yellow_cards / $homeTotalMatches : 0;
                            $homeAverageYellowCardsHome = $homeHomeMatches > 0 ? $match->homeTeam->h_yellow_cards / $homeHomeMatches : 0;
                            $homeAverageYellowCardsAway = $homeAwayMatches > 0 ? $match->homeTeam->a_yellow_cards / $homeAwayMatches : 0;

                            $homeAverageRedCardsTotal = $homeTotalMatches > 0 ? $match->homeTeam->t_red_cards / $homeTotalMatches : 0;
                            $homeAverageRedCardsHome = $homeHomeMatches > 0 ? $match->homeTeam->h_red_cards / $homeHomeMatches : 0;
                            $homeAverageRedCardsAway = $homeAwayMatches > 0 ? $match->homeTeam->a_red_cards / $homeAwayMatches : 0;

                            // Medie per partita - Statistiche combinate (squadra + avversari)
                            $homeTotalFoulsCombined = $match->homeTeam->t_fouls + $match->homeTeam->fouls_conc_h + $match->homeTeam->fouls_conc_a;
                            $homeFoulsCombinedHome = $match->homeTeam->h_fouls + $match->homeTeam->fouls_conc_h;
                            $homeFoulsCombinedAway = $match->homeTeam->a_fouls + $match->homeTeam->fouls_conc_a;

                            $homeAverageFoulsCombinedTotal = $homeTotalMatches > 0 ? $homeTotalFoulsCombined / $homeTotalMatches : 0;
                            $homeAverageFoulsCombinedHome = $homeHomeMatches > 0 ? $homeFoulsCombinedHome / $homeHomeMatches : 0;
                            $homeAverageFoulsCombinedAway = $homeAwayMatches > 0 ? $homeFoulsCombinedAway / $homeAwayMatches : 0;

                            $homeTotalYellowCardsCombined = $match->homeTeam->t_yellow_cards + $match->homeTeam->yc_conc_h + $match->homeTeam->yc_conc_a;
                            $homeYellowCardsCombinedHome = $match->homeTeam->h_yellow_cards + $match->homeTeam->yc_conc_h;
                            $homeYellowCardsCombinedAway = $match->homeTeam->a_yellow_cards + $match->homeTeam->yc_conc_a;

                            $homeAverageYellowCardsCombinedTotal = $homeTotalMatches > 0 ? $homeTotalYellowCardsCombined / $homeTotalMatches : 0;
                            $homeAverageYellowCardsCombinedHome = $homeHomeMatches > 0 ? $homeYellowCardsCombinedHome / $homeHomeMatches : 0;
                            $homeAverageYellowCardsCombinedAway = $homeAwayMatches > 0 ? $homeYellowCardsCombinedAway / $homeAwayMatches : 0;

                            $homeTotalRedCardsCombined = $match->homeTeam->t_red_cards + $match->homeTeam->rc_conc_h + $match->homeTeam->rc_conc_a;
                            $homeRedCardsCombinedHome = $match->homeTeam->h_red_cards + $match->homeTeam->rc_conc_h;
                            $homeRedCardsCombinedAway = $match->homeTeam->a_red_cards + $match->homeTeam->rc_conc_a;

                            $homeAverageRedCardsCombinedTotal = $homeTotalMatches > 0 ? $homeTotalRedCardsCombined / $homeTotalMatches : 0;
                            $homeAverageRedCardsCombinedHome = $homeHomeMatches > 0 ? $homeRedCardsCombinedHome / $homeHomeMatches : 0;
                            $homeAverageRedCardsCombinedAway = $homeAwayMatches > 0 ? $homeRedCardsCombinedAway / $homeAwayMatches : 0;

                            // Arrotondamenti a un decimale
                            $homeAverageFoulsTotal = round($homeAverageFoulsTotal, 1);
                            $homeAverageFoulsHome = round($homeAverageFoulsHome, 1);
                            $homeAverageFoulsAway = round($homeAverageFoulsAway, 1);

                            $homeAverageYellowCardsTotal = round($homeAverageYellowCardsTotal, 1);
                            $homeAverageYellowCardsHome = round($homeAverageYellowCardsHome, 1);
                            $homeAverageYellowCardsAway = round($homeAverageYellowCardsAway, 1);

                            $homeAverageRedCardsTotal = round($homeAverageRedCardsTotal, 1);
                            $homeAverageRedCardsHome = round($homeAverageRedCardsHome, 1);
                            $homeAverageRedCardsAway = round($homeAverageRedCardsAway, 1);

                            $homeAverageFoulsCombinedTotal = round($homeAverageFoulsCombinedTotal, 1);
                            $homeAverageFoulsCombinedHome = round($homeAverageFoulsCombinedHome, 1);
                            $homeAverageFoulsCombinedAway = round($homeAverageFoulsCombinedAway, 1);

                            $homeAverageYellowCardsCombinedTotal = round($homeAverageYellowCardsCombinedTotal, 1);
                            $homeAverageYellowCardsCombinedHome = round($homeAverageYellowCardsCombinedHome, 1);
                            $homeAverageYellowCardsCombinedAway = round($homeAverageYellowCardsCombinedAway, 1);

                            $homeAverageRedCardsCombinedTotal = round($homeAverageRedCardsCombinedTotal, 1);
                            $homeAverageRedCardsCombinedHome = round($homeAverageRedCardsCombinedHome, 1);
                            $homeAverageRedCardsCombinedAway = round($homeAverageRedCardsCombinedAway, 1);

                            // Partite giocate squadra ospite
                            $awayTotalMatches = $match->awayTeam->t_played;
                            $awayHomeMatches = $match->awayTeam->h_played;
                            $awayAwayMatches = $match->awayTeam->a_played;

                            // Medie per partita - Statistiche della squadra ospite
                            $awayAverageFoulsTotal = $awayTotalMatches > 0 ? $match->awayTeam->t_fouls / $awayTotalMatches : 0;
                            $awayAverageFoulsHome = $awayHomeMatches > 0 ? $match->awayTeam->h_fouls / $awayHomeMatches : 0;
                            $awayAverageFoulsAway = $awayAwayMatches > 0 ? $match->awayTeam->a_fouls / $awayAwayMatches : 0;

                            $awayAverageYellowCardsTotal = $awayTotalMatches > 0 ? $match->awayTeam->t_yellow_cards / $awayTotalMatches : 0;
                            $awayAverageYellowCardsHome = $awayHomeMatches > 0 ? $match->awayTeam->h_yellow_cards / $awayHomeMatches : 0;
                            $awayAverageYellowCardsAway = $awayAwayMatches > 0 ? $match->awayTeam->a_yellow_cards / $awayAwayMatches : 0;

                            $awayAverageRedCardsTotal = $awayTotalMatches > 0 ? $match->awayTeam->t_red_cards / $awayTotalMatches : 0;
                            $awayAverageRedCardsHome = $awayHomeMatches > 0 ? $match->awayTeam->h_red_cards / $awayHomeMatches : 0;
                            $awayAverageRedCardsAway = $awayAwayMatches > 0 ? $match->awayTeam->a_red_cards / $awayAwayMatches : 0;

                            // Medie per partita - Statistiche combinate (squadra + avversari)
                            $awayTotalFoulsCombined = $match->awayTeam->t_fouls + $match->awayTeam->fouls_conc_h + $match->awayTeam->fouls_conc_a;
                            $awayFoulsCombinedHome = $match->awayTeam->h_fouls + $match->awayTeam->fouls_conc_h;
                            $awayFoulsCombinedAway = $match->awayTeam->a_fouls + $match->awayTeam->fouls_conc_a;

                            $awayAverageFoulsCombinedTotal = $awayTotalMatches > 0 ? $awayTotalFoulsCombined / $awayTotalMatches : 0;
                            $awayAverageFoulsCombinedHome = $awayHomeMatches > 0 ? $awayFoulsCombinedHome / $awayHomeMatches : 0;
                            $awayAverageFoulsCombinedAway = $awayAwayMatches > 0 ? $awayFoulsCombinedAway / $awayAwayMatches : 0;

                            $awayTotalYellowCardsCombined = $match->awayTeam->t_yellow_cards + $match->awayTeam->yc_conc_h + $match->awayTeam->yc_conc_a;
                            $awayYellowCardsCombinedHome = $match->awayTeam->h_yellow_cards + $match->awayTeam->yc_conc_h;
                            $awayYellowCardsCombinedAway = $match->awayTeam->a_yellow_cards + $match->awayTeam->yc_conc_a;

                            $awayAverageYellowCardsCombinedTotal = $awayTotalMatches > 0 ? $awayTotalYellowCardsCombined / $awayTotalMatches : 0;
                            $awayAverageYellowCardsCombinedHome = $awayHomeMatches > 0 ? $awayYellowCardsCombinedHome / $awayHomeMatches : 0;
                            $awayAverageYellowCardsCombinedAway = $awayAwayMatches > 0 ? $awayYellowCardsCombinedAway / $awayAwayMatches : 0;

                            $awayTotalRedCardsCombined = $match->awayTeam->t_red_cards + $match->awayTeam->rc_conc_h + $match->awayTeam->rc_conc_a;
                            $awayRedCardsCombinedHome = $match->awayTeam->h_red_cards + $match->awayTeam->rc_conc_h;
                            $awayRedCardsCombinedAway = $match->awayTeam->a_red_cards + $match->awayTeam->rc_conc_a;

                            $awayAverageRedCardsCombinedTotal = $awayTotalMatches > 0 ? $awayTotalRedCardsCombined / $awayTotalMatches : 0;
                            $awayAverageRedCardsCombinedHome = $awayHomeMatches > 0 ? $awayRedCardsCombinedHome / $awayHomeMatches : 0;
                            $awayAverageRedCardsCombinedAway = $awayAwayMatches > 0 ? $awayRedCardsCombinedAway / $awayAwayMatches : 0;

                            // Arrotondamenti a un decimale
                            $awayAverageFoulsTotal = round($awayAverageFoulsTotal, 1);
                            $awayAverageFoulsHome = round($awayAverageFoulsHome, 1);
                            $awayAverageFoulsAway = round($awayAverageFoulsAway, 1);

                            $awayAverageYellowCardsTotal = round($awayAverageYellowCardsTotal, 1);
                            $awayAverageYellowCardsHome = round($awayAverageYellowCardsHome, 1);
                            $awayAverageYellowCardsAway = round($awayAverageYellowCardsAway, 1);

                            $awayAverageRedCardsTotal = round($awayAverageRedCardsTotal, 1);
                            $awayAverageRedCardsHome = round($awayAverageRedCardsHome, 1);
                            $awayAverageRedCardsAway = round($awayAverageRedCardsAway, 1);

                            $awayAverageFoulsCombinedTotal = round($awayAverageFoulsCombinedTotal, 1);
                            $awayAverageFoulsCombinedHome = round($awayAverageFoulsCombinedHome, 1);
                            $awayAverageFoulsCombinedAway = round($awayAverageFoulsCombinedAway, 1);

                            $awayAverageYellowCardsCombinedTotal = round($awayAverageYellowCardsCombinedTotal, 1);
                            $awayAverageYellowCardsCombinedHome = round($awayAverageYellowCardsCombinedHome, 1);
                            $awayAverageYellowCardsCombinedAway = round($awayAverageYellowCardsCombinedAway, 1);

                            $awayAverageRedCardsCombinedTotal = round($awayAverageRedCardsCombinedTotal, 1);
                            $awayAverageRedCardsCombinedHome = round($awayAverageRedCardsCombinedHome, 1);
                            $awayAverageRedCardsCombinedAway = round($awayAverageRedCardsCombinedAway, 1);

                            // Calcolo delle percentuali Over 0.5
                            $homeOver05Percentage = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->t_over_0_5_ht / $match->homeTeam->t_played) * 100, 2) : 0;
                            $awayOver05Percentage = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->t_over_0_5_ht / $match->homeTeam->t_played) * 100, 2) : 0;
                            $averageOver05 = round(($homeOver05Percentage + $awayOver05Percentage) / 2, 2);

                            // Calcolo delle percentuali Over 1.5
                            $homeOver15Percentage = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->t_over_1_5_ht / $match->homeTeam->t_played) * 100, 2) : 0;
                            $awayOver15Percentage = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->t_over_1_5_ht / $match->homeTeam->t_played) * 100, 2) : 0;
                            $averageOver15 = round(($homeOver15Percentage + $awayOver15Percentage) / 2, 2);

                            // Calcolo delle percentuali Over 2.5
                            $homeOver25Percentage = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->t_over_2_5_ht / $match->homeTeam->t_played) * 100, 2) : 0;
                            $awayOver25Percentage = $match->homeTeam->t_played > 0 ? round(($match->homeTeam->t_over_2_5_ht / $match->homeTeam->t_played) * 100, 2) : 0;
                            $averageOver25 = round(($homeOver25Percentage + $awayOver25Percentage) / 2, 2);
                        @endphp

                            <tr>
                                <!-- Orario della partita -->
                                <td data-label="Ora">{{ \Carbon\Carbon::parse($match->match_time)->format('H:i') }}</td>

                                <!-- Lega della partita -->
                                <td data-label="Campionato"><span class="league"> {{ config('leagues.by_id.' . $match->homeTeam->league_id, 'Lega Sconosciuta') }} </span></td>

                                <!-- Logo squadra di casa (sempre visibile) -->
                                <td data-label="Logo Casa"><img src="https://media.api-sports.io/football/teams/{{ $match->homeTeam->team_id }}.png" alt="{{ $match->homeTeam->name }}" class="team-logo"></td>

                                                          <!-- Fascia della squadra di casa (visibile solo se 'Risultati' è selezionato) -->


                                <!-- Nome squadra di casa -->
                                <td data-label="Nome Casa" class="col-nome-squadra">{{ $match->homeTeam->name }}</td>
                                <td data-label="Fascia Casa" class="col-fascia col-risultati">
                                    @if($match->homeTeam->fascia == 'Ottima')
                                        <i class="fa-solid fa-bomb" style="color: #004d00;" title="Ottima"></i> <!-- Verde molto scuro -->
                                    @elseif($match->homeTeam->fascia == 'Buona')
                                        <i class="fa-regular fa-thumbs-up" style="color: #66ff66;" title="Buona"></i> <!-- Verde chiaro -->
                                    @elseif($match->homeTeam->fascia == 'Media')
                                        <i class="fa-solid fa-scale-balanced" style="color: #ffa500;" title="Media"></i> <!-- Arancio -->
                                    @elseif($match->homeTeam->fascia == 'Mediocre')
                                        <i class="fa-regular fa-thumbs-down" style="color: #ff6666;" title="Mediocre"></i> <!-- Rosso chiaro -->
                                    @elseif($match->homeTeam->fascia == 'Scarsa')
                                        <i class="fa-solid fa-skull-crossbones" style="color: #8b0000;" title="Scarsa"></i> <!-- Rosso molto scuro -->
                                    @endif
                                </td>


                                <td data-label="Fascia Ospite" class="col-fascia col-risultati">
                                    @if($match->awayTeam->fascia == 'Ottima')
                                    <i class="fa-solid fa-bomb" style="color: #004d00;" title="Ottima"></i> <!-- Verde molto scuro -->
                                @elseif($match->awayTeam->fascia == 'Buona')
                                    <i class="fa-regular fa-thumbs-up" style="color: #66ff66;" title="Buona"></i> <!-- Verde chiaro -->
                                @elseif($match->awayTeam->fascia == 'Media')
                                    <i class="fa-solid fa-scale-balanced" style="color: #ffa500;" title="Media"></i> <!-- Arancio -->
                                @elseif($match->awayTeam->fascia == 'Mediocre')
                                    <i class="fa-regular fa-thumbs-down" style="color: #ff6666;" title="Mediocre"></i> <!-- Rosso chiaro -->
                                @elseif($match->awayTeam->fascia == 'Scarsa')
                                    <i class="fa-solid fa-skull-crossbones" style="color: #8b0000;" title="Scarsa"></i> <!-- Rosso molto scuro -->
                                @endif
                                </td>
                                <!-- Nome squadra ospite -->
                                <td data-label="Nome Ospite" class="col-nome-squadra">{{ $match->awayTeam->name }}</td>

                                <!-- Fascia della squadra ospite (visibile solo se 'Risultati' è selezionato) -->

                                <!-- Logo squadra ospite (sempre visibile) -->
                                <td data-label="Logo Ospite"><img src="https://media.api-sports.io/football/teams/{{ $match->awayTeam->team_id }}.png" alt="{{ $match->awayTeam->name }}" class="team-logo"></td>

                                <!-- Risultati -->
                                <td data-label="1" class="col-risultati"><span>{{ number_format($matchesProbabilities[$match->id]['homeWin'] * 100, 0) }}%</span></td>
                                <td data-label="X" class="col-risultati"><span>{{ number_format($matchesProbabilities[$match->id]['draw'] * 100, 0) }}%</span></td>
                                <td data-label="2" class="col-risultati"><span>{{ number_format($matchesProbabilities[$match->id]['awayWin'] * 100, 0) }}%</span></td>

                                <!-- Gol -->
                                <td data-label="Over 1.5" class="col-gol"><span>{{ number_format($overUnderProbabilities[$match->id]['over_1_5'], 0) }}%</span></td>
                                <td data-label="Over 2.5" class="col-gol"><span>{{ number_format($overUnderProbabilities[$match->id]['over_2_5'], 0) }}%</span></td>
                                <td data-label="Over 3.5" class="col-gol"><span>{{ number_format($overUnderProbabilities[$match->id]['over_3_5'], 0) }}%</span></td>
                                <td data-label="G/G" class="col-gol"><span>{{ number_format($overUnderProbabilities[$match->id]['both_teams_to_score'], 0) }}%</span></td>

                                <!-- Corner -->
                                <td data-label="Corner" class="col-corner"> @if(isset($expectedCornersData[$match->id])) <span>{{ number_format($expectedCornersData[$match->id], 2) }}</span> @else <span>N/A</span> @endif </td>
                                <td data-label="Corner C" class="col-corner">{{ $match->homeTeam->t_played > 0 ? round(($match->homeTeam->t_corners / $match->homeTeam->t_played), 2) : 0 }}</td>
                                <td data-label="Corner F" class="col-corner">{{ $match->awayTeam->t_played > 0 ? round(($match->awayTeam->t_corners / $match->awayTeam->t_played), 2) : 0 }}</td>

                                <!-- Tiri Totali -->
                                <td data-label="Tiri Totali" class="col-tiri"><span>{{ $mediaTiriTotaliMatch }}</span></td>
                                <td data-label="Tiri Tot C" class="col-tiri">{{ $mediaTiriTotaliCasaS }}</td>
                                <td data-label="Tiri Tot F" class="col-tiri">{{ $mediaTiriTotaliFuoriS }}</td>

                                <!-- Tiri in Porta -->
                                <td data-label="Tiri in Porta" class="col-tiri"><span>{{ $mediaTiriInPortaMatch }}</span></td>
                                <td data-label="Tiri Porta C" class="col-tiri">{{ $mediaTiriInPortaCasaS }}</td>
                                <td data-label="Tiri Porta F" class="col-tiri">{{ $mediaTiriInPortaFuoriS }}</td>

                                <!-- Sanzioni -->
                                <td data-label="Cartellini" class="col-sanzioni"><span>{{ $totalCardsMatch }}</span></td>
                                <td data-label="Cartellini C" class="col-sanzioni">{{ $homeTotalCardsPerMatch }}</td>
                                <td data-label="Cartellini F" class="col-sanzioni">{{ $awayTotalCardsPerMatch }}</td>

                                <!-- Falli -->
                                <td data-label="Falli" class="col-sanzioni"><span>{{ $totalFoulsMatch }}</span></td>
                                <td data-label="Falli C" class="col-sanzioni">{{ $homeTotalFoulsPerMatch }}</td>
                                <td data-label="Falli F" class="col-sanzioni">{{ $awayTotalFoulsPerMatch }}</td>

                                 <!-- Tempo 1 -->
                                 <td data-label="over 0.5" class="col-tempo1"><span>{{ $averageOver05 }}%</span></td>
                                 <td data-label="over 1.5" class="col-tempo1"><span>{{ $averageOver15 }}%</span></td>
                                 <td data-label="over 2.5" class="col-tempo1"><span>{{ $averageOver25 }}%</span></td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- JavaScript per Gestione Filtri -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-button');
    const table = document.querySelector('.matches-table');

    // Funzione per nascondere tutte le sezioni
    function hideAllSections() {
        const sections = ['risultati', 'gol', 'corner', 'tiri', 'sanzioni', 'tempo1'];
        sections.forEach(section => {
            const columns = table.querySelectorAll(`.col-${section}`);
            columns.forEach(col => {
                if (!col.classList.contains('logo-column')) { // Evita di nascondere i loghi
                    col.classList.remove('visible-column');
                    col.classList.add('hidden-column');
                }
            });
        });

        // Nascondi anche le colonne 'Fascia'
        const fasciaColumns = table.querySelectorAll('.col-fascia');
        fasciaColumns.forEach(col => {
            col.classList.remove('visible-column');
            col.classList.add('hidden-column');
        });
    }

    // Funzione per mostrare una sezione specifica
    function showSection(section) {
        const columns = table.querySelectorAll(`.col-${section}`);
        columns.forEach(col => {
            col.classList.remove('hidden-column');
            col.classList.add('visible-column');
        });

        // Se la sezione selezionata è 'risultati', mostra le colonne 'Fascia'
        if(section === 'risultati') {
            const fasciaColumns = table.querySelectorAll('.col-fascia');
            fasciaColumns.forEach(col => {
                col.classList.remove('hidden-column');
                col.classList.add('visible-column');
            });
        }
    }

    // Funzione per rimuovere la classe 'active' da tutti i pulsanti
    function deactivateAllButtons() {
        filterButtons.forEach(button => {
            button.classList.remove('active');
        });
    }

    // Funzione di inizializzazione per impostare il filtro predefinito (Risultati)
    function initializeFilters() {
        hideAllSections();
        filterButtons.forEach(button => {
            if(button.getAttribute('data-section') === 'risultati') {
                button.classList.add('active');
                showSection('risultati');
            }
        });
    }

    // Inizializza lo stato delle colonne
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Deattiva tutti i pulsanti e attiva quello cliccato
            deactivateAllButtons();
            this.classList.add('active');

            // Nascondi tutte le sezioni e mostra quella selezionata
            hideAllSections();
            const section = this.getAttribute('data-section');
            showSection(section);
        });
    });

    // Chiama la funzione di inizializzazione per mostrare di default "Risultati"
    initializeFilters();
});


</script>

@endsection
