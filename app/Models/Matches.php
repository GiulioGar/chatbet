<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'home_id',
        'away_id',
        'match_date',
        'match_time',
        'home_score',
        'away_score',
        'home_ht', // Punteggio primo tempo squadra di casa
        'away_ht', // Punteggio primo tempo squadra ospite
        'home_ft', // Punteggio secondo tempo squadra di casa
        'away_ft', // Punteggio secondo tempo squadra ospite
        'referee'
    ];
}
