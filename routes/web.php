<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

//admin controller
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UpdateDataController;

//Leagues Controller
use App\Http\Controllers\Italy\SerieAController;
use App\Http\Controllers\England\PremierLeagueController;
use App\Http\Controllers\Spain\LaLigaController;
use App\Http\Controllers\Germany\BundesligaController;
use App\Http\Controllers\France\Ligue1Controller;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/users/{user}/role', [AdminController::class, 'changeRole'])->name('admin.users.changeRole');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/update-data', [UpdateDataController::class, 'show'])->name('admin.update-data');
    Route::post('/admin/update-data', [UpdateDataController::class, 'update'])->name('admin.update-data.execute');
});


// Rotte per le leghe italiane
Route::get('/italy/seriea', [SerieAController::class, 'index'])->name('italy.seriea');

// Rotte per le leghe inglesi
Route::get('/england/premierleague', [PremierLeagueController::class, 'index'])->name('england.premierleague');

// Rotte per le leghe spagnole
Route::get('/spain/laliga', [LaLigaController::class, 'index'])->name('spain.laliga');

// Rotte per le leghe tedesche
Route::get('/germany/bundesliga', [BundesligaController::class, 'index'])->name('germany.bundesliga');

// Rotte per le leghe francesi
Route::get('/france/ligue1', [Ligue1Controller::class, 'index'])->name('france.ligue1');



require __DIR__.'/auth.php';
