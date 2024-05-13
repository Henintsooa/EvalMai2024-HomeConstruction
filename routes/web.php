<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DevisController;
use Illuminate\Support\Facades\Route;



Route::get('/listeDevis', [DevisController::class, 'listeDevis'])->name('listeDevis'); 
Route::post('/insertDemandeDevis', [DevisController::class, 'insertDemandeDevis'])->name('insertDemandeDevis'); 
Route::get('/finition/{idMaison}', [DevisController::class, 'finition'])->name('finition'); 
Route::get('/loginClient', [HomeController::class, 'loginClient'])->name('loginClient'); 

Route::post('/reset-database', [HomeController::class, 'reset']);

Route::get('/user', [HomeController::class, 'user'])->name('user'); 
// Route::get('/dashboard_user', [HomeController::class, 'user'])->name('dashboard_user'); 
Route::get('/dashboard_admin', [HomeController::class, 'admin'])->name('dashboard_admin'); 

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
