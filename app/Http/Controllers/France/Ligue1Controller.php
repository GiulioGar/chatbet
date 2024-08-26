<?php

namespace App\Http\Controllers\France;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Ligue1Controller extends Controller
{
    public function index()
    {
        return view('france.ligue1');
    }
}
