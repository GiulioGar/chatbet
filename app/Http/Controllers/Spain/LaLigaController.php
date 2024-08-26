<?php

namespace App\Http\Controllers\Spain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaLigaController extends Controller
{
    public function index()
    {
        return view('spain.laliga');
    }
}
