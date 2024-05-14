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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;    
use Illuminate\Support\Facades\Validator;


class DevisController extends Controller
{
    public function finition(Request $request)
    {
        $idMaison = $request->input('idMaison');
        $finitions = Finition::all();
        return view('html.finition',['finitions'=>$finitions,'idMaison'=>$idMaison]);  
    }

    public function insertDemandeDevis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idFinition' => 'required|integer',
            'dateDebut' => 'required|date',
            'idMaison' => 'required|integer',
        ], [
            'idFinition.required' => 'Le champ Finition est requis.',
            'idFinition.integer' => 'Le champ Finition doit être un entier.',
            'dateDebut.required' => 'Le champ Date début est requis.',
            'dateDebut.date' => 'Le champ Date début doit être une date valide.',
            'idMaison.required' => 'Le champ idMaison est requis.',
            'idMaison.integer' => 'Le champ idMaison doit être un entier.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $client = session('client');
        $maison = DB::table('maison')->where('idMaison', $request->idMaison)->first();
        $duree = DB::table('typeMaison')->where('idTypeMaison', $maison->idTypeMaison)->first()->duree;
        
        $dateFin = date('Y-m-d', strtotime($request->dateDebut. ' + '.$duree.' days'));
        
        DB::table('DemandeDevis')->insert([
            'idMaison' => $request->idMaison,
            'idClient' => $client->idClient,
            'idFinition' => $request->idFinition,
            'DateDebut' => $request->dateDebut,
            'DateFin' => $dateFin,
        ]);
        $prixMaisons=DB::table('prixMaison')->get();
        return view('html.index',['prixMaisons'=>$prixMaisons]);  
    }

    public function listeDevis()
    {
        $client = session('client');
        $listeDevis=DB::table('ViewListeDevis_Paiement')->where('idClient', $client->idClient)->get();
        return view('html.listeDevis',['listeDevis'=>$listeDevis]);
    }

    public function detailsDevis()
    {
        $idDevis = request()->query('idDevis');
        $idDemandeDevis = request()->query('idDemandeDevis');

        $listeDevis=DB::table('ViewListeDevis_Paiement')->where('idDemandeDevis', $idDemandeDevis)->first();

        $detailsDevis = DB::table('devisDetails')
            ->join('travaux', 'travaux.idTravaux', '=', 'devisDetails.idTravaux')
            ->select('travaux.numero', 'travaux.designation', 'travaux.unite', 'devisDetails.quantite', 'devisDetails.pu', 'devisDetails.prixTotal')
            ->where('devisDetails.idDevis', $idDevis)
            ->get();

        return view('html.detailsDevis',['detailsDevis'=>$detailsDevis,'listeDevis'=>$listeDevis]);
    }

    public function pdfDevis()
    {
        $idDevis = request()->query('idDevis');
        $idDemandeDevis = request()->query('idDemandeDevis');
        
        $listeDevis=DB::table('ViewListeDevis_Paiement')->where('idDemandeDevis', $idDemandeDevis)->first();

        $detailsDevis = DB::table('devisDetails')
            ->join('travaux', 'travaux.idTravaux', '=', 'devisDetails.idTravaux')
            ->select('travaux.numero', 'travaux.designation', 'travaux.unite', 'devisDetails.quantite', 'devisDetails.pu', 'devisDetails.prixTotal')
            ->where('devisDetails.idDevis', $idDevis)
            ->get();
        
        $html = View::make('pdf.PdfDetailsDevis')->with(['detailsDevis'=>$detailsDevis,'listeDevis'=>$listeDevis])->render();

        // Créez un nouvel objet Dompdf
        $dompdf = new Dompdf();

        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendez le document PDF
        $dompdf->render();

        // Générez le nom du fichier PDF
        $filename = 'devisDetails.pdf';

        // Téléchargez le fichier PDF
        return $dompdf->stream($filename);
    }
    

    public function listeDevisAdmin()
    {
        $client = session('client');
        $listeDevis=DB::table('ViewListeDevis_Paiement')->get();
        return view('html.adminListeDevis',['listeDevis'=>$listeDevis]);
    }
}
