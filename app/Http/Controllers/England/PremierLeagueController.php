<?php

namespace App\Http\Controllers\England;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PremierLeagueController extends Controller
{
    public function index()
    {
        return view('england.premierleague');
    }
}
