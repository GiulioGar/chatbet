<?php

namespace App\Http\Controllers\Germany;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BundesligaController extends Controller
{
    public function index()
    {
        return view('germany.bundesliga');
    }
}
