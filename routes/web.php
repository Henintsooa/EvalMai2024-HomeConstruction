<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TravauxController;
use App\Http\Controllers\FinitionController;
use Illuminate\Support\Facades\Route;



Route::put('/editFinition', [FinitionController::class, 'editFinition'])->name('editFinition'); 
Route::get('/updateFinition/{idFinition}', [FinitionController::class, 'updateFinition'])->name('updateFinition'); 
Route::get('/adminFinition', [FinitionController::class, 'finition'])->name('adminFinition'); 

Route::put('/editTravaux', [TravauxController::class, 'editTravaux'])->name('editTravaux'); 
Route::get('/updateTravaux/{idTravaux}', [TravauxController::class, 'updateTravaux'])->name('updateTravaux'); 
Route::get('/travaux', [TravauxController::class, 'travaux'])->name('travaux'); 
// Route::post('/importDevis', [ImportController::class, 'importDevis'])->name('importDevis');
Route::post('/importPaiement', [ImportController::class, 'importPaiement'])->name('importPaiement');
Route::post('/importCsv', [ImportController::class, 'importCsv'])->name('importCsv');
Route::get('/importDonnee', [ImportController::class, 'importDonnee'])->name('importDonnee'); 

Route::post('/histogramme', [HomeController::class, 'admin'])->name('histogramme'); 

Route::post('/insertPaiement', [PaiementController::class, 'insertPaiement'])->name('insertPaiement');

Route::get('/listeDevisAdmin', [DevisController::class, 'listeDevisAdmin'])->name('listeDevisAdmin'); 

Route::post('/insertPaiement', [PaiementController::class, 'insertPaiement'])->name('insertPaiement');
Route::get('/paiement/{idDemandeDevis}', [PaiementController::class, 'paiement'])->name('paiement');
Route::get('/pdfDevis', [DevisController::class, 'pdfDevis'])->name('pdfDevis');
Route::get('/detailsDevis', [DevisController::class, 'detailsDevis'])->name('detailsDevis'); 
Route::get('/listeDevis', [DevisController::class, 'listeDevis'])->name('listeDevis'); 
Route::post('/insertDemandeDevis', [DevisController::class, 'insertDemandeDevis'])->name('insertDemandeDevis'); 
Route::get('/finition', [DevisController::class, 'finition'])->name('finition'); 
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
