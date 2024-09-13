<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            $updatedMatches = $this->footballApiService->updateAllMatches();
            return back()->with('success', $updatedMatches . ' partite sono state aggiornate con successo.');
        } elseif ($request->input('action') == 'updateStatistics') {
            // Chiama l'aggiornamento delle statistiche di match
            $updatedStatistics = $this->footballApiService->updateMatchStatistics();

            // Chiama la funzione per aggiornare val_pres_h e val_pres_a
            $message = $this->footballApiService->updateValPresFields();

            return back()->with('success', $updatedStatistics . ' statistiche di partite sono state aggiornate. ' . $message);
        }

        return back()->with('error', 'Azione non valida.');
    }
}
