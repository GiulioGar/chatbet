<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

//admin controller
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UpdateDataController;

//Stats Controller
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


use App\Http\Controllers\LeagueController;

//rotta per pagina delle stastiche leghe
Route::get('/league/{leagueSlug}', [LeagueController::class, 'show'])->name('league.show');

//rotta per la pagina delle statistiche partita
Route::get('/statMatch/{homeTeam}/{awayTeam}', [MatchController::class, 'showStatistics'])->name('match.statMatch');

// Rotta per visualizzare i match per una data specifica (default: oggi)
Route::get('/todayMatches/{date?}', [MatchController::class, 'todayMatches'])->name('match.todayMatches');







Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/users/{user}/role', [AdminController::class, 'changeRole'])->name('users.changeRole');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/update-data', [UpdateDataController::class, 'show'])->name('admin.update-data');
    Route::post('/admin/update-data', [UpdateDataController::class, 'update'])->name('admin.update-data.execute');
    Route::post('/admin/update-teams', [TeamController::class, 'updateTeams'])->name('admin.update-teams.execute');
});






require __DIR__.'/auth.php';
