<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Aggiungi questa linea
use Illuminate\Http\Request;
use App\Services\FootballApiService;

class UpdateDataController extends Controller
{
    protected $footballApiService;

    public function __construct(FootballApiService $footballApiService)
    {
        $this->footballApiService = $footballApiService;
    }

    public function show()
    {
        return view('admin.update-data');
    }

    public function update(Request $request)
    {
        if ($request->input('action') == 'updateMatches') {
            $updatedMatches = app(FootballApiService::class)->updateAllMatches();
            return back()->with('success', $updatedMatches . ' partite sono state aggiornate con successo.');
        } elseif ($request->input('action') == 'updateStatistics') {
            $updatedMatches = app(FootballApiService::class)->updateMatchStatistics();
            return back()->with('success', $updatedMatches . ' statistiche di partite sono state aggiornate con successo.');
        }

        return back()->with('error', 'Azione non valida.');
    }

}
