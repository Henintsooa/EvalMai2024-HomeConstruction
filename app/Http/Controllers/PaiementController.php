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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $montantTotal = DB::table('viewListeDevis_Paiement')->where('idDemandeDevis', $request->input('idDemandeDevis'))->value('prixDevisTotal');

        if ($request->input('montant') < 0) {
            return response()->json(['errors' => ['montant' => ['Le montant ne peut pas être négatif.']]], 422);
        }

        if ($request->input('montant') > $montantTotal) {
            return response()->json(['errors' => ['montant' => ['Le montant ne peut pas dépasser le montant total.']]], 422);
        }

        $idPaiement = DB::table('historiquePaiement')->insertGetId([
            'datePaiement' => $request->input('datePaiement'),
            'payer' => $request->input('montant'),
            'idDemandeDevis' => $request->input('idDemandeDevis'),
            'refDevis' => DB::table('demandeDevis')->where('idDemandeDevis', $request->input('idDemandeDevis'))->value('refDevis'),
            'refPaiement' => 0,
        ]);
        $refPaiement = 'P00' . $idPaiement;

        DB::table('historiquePaiement')->where('idHistorique', $idPaiement)->update([
            'refPaiement' => $refPaiement,
        ]);

        return response()->json(['message' => 'Paiement enregistré avec succès.'], 200);
    }
}
