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
        $idTypeMaison = $request->input('idTypeMaison');
        $finitions = Finition::all();
        return view('html.finition',['finitions'=>$finitions,'idTypeMaison'=>$idTypeMaison]);  
    }

    public function insertDemandeDevis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idFinition' => 'required|integer',
            'dateDebut' => 'required|date',
            'idTypeMaison' => 'required|integer',
            'lieu' => 'required|string',
        ], [
            'idFinition.required' => 'Le champ Finition est requis.',
            'idFinition.integer' => 'Le champ Finition doit être un entier.',
            'dateDebut.required' => 'Le champ Date début est requis.',
            'dateDebut.date' => 'Le champ Date début doit être une date valide.',
            'idTypeMaison.required' => 'Le champ idTypeMaison est requis.',
            'idTypeMaison.integer' => 'Le champ idTypeMaison doit être un entier.',
            'lieu.required' => 'Le champ lieu est requis.',

        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $client = session('client');
        $duree = DB::table('typeMaison')->where('idTypeMaison', $request->idTypeMaison)->first()->duree;
        
        $dateFin = date('Y-m-d', strtotime($request->dateDebut. ' + '.$duree.' days'));
        
        $idDemandeDevis = DB::table('DemandeDevis')->insertGetId([
            'idTypeMaison' => $request->idTypeMaison,
            'idClient' => $client->idClient,
            'idFinition' => $request->idFinition,
            'pourcentage' => Finition::where('idFinition', $request->idFinition)->value('pourcentage'),
            'DateDebut' => $request->dateDebut,
            'DateFin' => $dateFin,
            'DateCreation' => date('Y-m-d'),
            'lieu' => $request->lieu,
            'refDevis' => 0,
        ]);

        $refDevis = 'D00' . $idDemandeDevis;

        DB::table('DemandeDevis')->where('idDemandeDevis', $idDemandeDevis)->update([
            'refDevis' => $refDevis,
        ]);
        $prixMaisons=DB::table('prixMaison')->get();
        return view('html.index',['prixMaisons'=>$prixMaisons]);  
    }

    public function listeDevis()
    {
        $client = session('client');
        $listeDevis=DB::table('ViewListeDevis_Paiement')->where('idClient', $client->idClient)->paginate(5);
        return view('html.listeDevis',['listeDevis'=>$listeDevis]);
    }

    public function detailsDevis()
    {
        $idDevis = request()->query('idDevis');
        $idDemandeDevis = request()->query('idDemandeDevis');

        $listeDevis=DB::table('ViewListeDevis_Paiement')->where('idDemandeDevis', $idDemandeDevis)->first();
        $histoPaiement=DB::table('ViewHistoPaiementDetails')->where('idDemandeDevis', $idDemandeDevis)->get();
         
        $detailsDevis = DB::table('devisDetails')
            ->join('travaux', 'travaux.idTravaux', '=', 'devisDetails.idTravaux')
            ->select('travaux.numero', 'travaux.designation', 'travaux.unite', 'devisDetails.quantite', 'devisDetails.pu', 'devisDetails.prixTotal')
            ->where('devisDetails.idDevis', $idDevis)
            ->get();

        return view('html.detailsDevis',['detailsDevis'=>$detailsDevis,'listeDevis'=>$listeDevis,'histoPaiement'=>$histoPaiement]);
    }

    public function pdfDevis()
    {
        $idDevis = request()->query('idDevis');
        $idDemandeDevis = request()->query('idDemandeDevis');
        
        $listeDevis=DB::table('ViewListeDevis_Paiement')->where('idDemandeDevis', $idDemandeDevis)->first();
        $histoPaiement=DB::table('ViewHistoPaiementDetails')->where('idDemandeDevis', $idDemandeDevis)->get();

        $detailsDevis = DB::table('devisDetails')
            ->join('travaux', 'travaux.idTravaux', '=', 'devisDetails.idTravaux')
            ->select('travaux.numero', 'travaux.designation', 'travaux.unite', 'devisDetails.quantite', 'devisDetails.pu', 'devisDetails.prixTotal')
            ->where('devisDetails.idDevis', $idDevis)
            ->get();
        
        $html = View::make('pdf.PdfDetailsDevis')->with(['detailsDevis'=>$detailsDevis,'listeDevis'=>$listeDevis,'histoPaiement'=>$histoPaiement])->render();

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
        $listeDevis=DB::table('ViewListeDevis_Paiement')->paginate(5);
        return view('html.adminListeDevis',['listeDevis'=>$listeDevis]);
    }
}
