<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FootballApiService;
use Illuminate\Http\Request;

class UpdateDataController extends Controller
{
    protected $footballApi;

    public function __construct(FootballApiService $footballApi)
    {
        $this->footballApi = $footballApi;
    }

    public function show()
    {
        return view('admin.update-data');
    }

    public function update(Request $request)
    {
        $this->footballApi->updateAllMatches(); // Questo aggiornerà tutti i match dei 5 campionati
        return redirect()->route('admin.update-data')->with('success', 'Tutti i match sono stati aggiornati con successo.');
    }
}
