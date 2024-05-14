<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;   
use App\Models\User;
use App\Models\Client;
use App\Models\Finition;
use App\Models\PrixMaison;
use App\Models\HistoriquePaiement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;    
use Illuminate\Support\Facades\Validator;


class PaiementController extends Controller
{
    public function paiement($idDemandeDevis)
    {
        return view('html.paiement', ['idDemandeDevis' => $idDemandeDevis]);   
    }

    public function insertPaiement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'datePaiement' => 'required|date',
            'montant' => 'required|numeric',
            'idDemandeDevis' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $montantTotal = DB::table('viewListeDevis_Paiement')->where('idDemandeDevis', $request->input('idDemandeDevis'))->value('prixDevisTotal');

        if ($request->input('montant') < 0) {
            return redirect()->back()->withErrors(['montant' => 'Le montant ne peut pas être négatif.'])->withInput();
        }

        if ($request->input('montant') > $montantTotal) {
            return redirect()->back()->withErrors(['montant' => 'Le montant ne peut pas dépasser le montant total.'])->withInput();
        }

        DB::table('historiquePaiement')->insert([
            'datePaiement' => $request->input('datePaiement'),
            'payer' => $request->input('montant'),
        ]);

        return redirect()->back()->with('success', 'Paiement enregistré avec succès.');
    }
}
