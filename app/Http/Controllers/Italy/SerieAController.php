<?php

namespace App\Http\Controllers\Italy;

use App\Http\Controllers\Controller;
use App\Services\FootballApiService;
use Illuminate\Http\Request;

class SerieAController extends Controller
{
    protected $footballApi;

    public function __construct(FootballApiService $footballApi)
    {
        $this->footballApi = $footballApi;
    }

    public function index()
    {

    }
}
