<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'league_id',
        'home_id',
        'away_id',
        'match_date',
        'match_time',
        'home_score',
        'away_score',
        'home_ht',
        'away_ht',
        'home_ft',
        'away_ft',
        'referee',
        'sog_home',
        'sog_away',
        'sof_home',
        'sof_away',
        'sib_home',
        'sib_away',
        'sob_home',
        'sob_away',
        'tsh_home',
        'tsh_away',
        'blk_home',
        'blk_away',
        'fouls_home',
        'fouls_away',
        'corners_home',
        'corners_away',
        'offsides_home',
        'offsides_away',
        'possession_home',
        'possession_away',
        'yc_home',
        'yc_away',
        'rc_home',
        'rc_away',
        'saves_home',
        'saves_away',
        'tpass_home',
        'tpass_away',
        'pacc_home',
        'pacc_away',
        'pperc_home',
        'pperc_away',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_id', 'team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_id', 'team_id');
    }

}
