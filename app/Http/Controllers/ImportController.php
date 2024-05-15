<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\User;
use App\Models\Client;
use App\Models\PrixMaison;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class ImportController extends Controller
{
    public function importDonnee()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
        $user = Auth::user();
        
        return view('html.importDonnee', ['user' => $user]);  
    }

    public function importCsv()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        $user = Auth::user();
        
        // Importation du fichier maisonTravauxFile
        $file = request()->file('maisonTravauxFile');
        $fileContents = file($file->getPathname());
        
        $row = 0;

        // Importation des données du fichier maisonTravauxFile
        foreach ($fileContents as $line) {
            $row++;

            // Si c'est la première ligne, sautez-la
            if ($row == 1) {
                continue;
            } 
            
            $data = str_getcsv($line);

            if ($data[6] < 0) {
                // Retourne une erreur ou arrête le processus
                return redirect()->back()->withErrors(['prix' => 'il y a un prix négatif']);
            }
            
            $data[2] = str_ireplace(',', '.', $data[2]);
            $data[5] = str_ireplace(',', '.', $data[5]);
            $data[6] = str_ireplace(',', '.', $data[6]);
            $data[7] = str_ireplace(',', '.', $data[7]);

            // Insérer dans la table importMaisonTravaux
            DB::table('importMaisonTravaux')->insert([
                'typeMaison' => $data[0],
                'description' => $data[1],
                'surface' => $data[2],
                'codeTravaux' => $data[3],
                'typeTravaux' => $data[4],
                'unite' => $data[5],
                'prixUnitaire' => $data[6],
                'quantite' => $data[7],
                'dureeTravaux' => $data[8],
            ]);
        }

        // Insertion des données dans les autres tables
        DB::statement('INSERT INTO typeMaison (nomMaison,duree)
        SELECT DISTINCT im.typeMaison, im.dureeTravaux
        FROM importMaisonTravaux im
        WHERE (im.typeMaison, im.dureeTravaux) NOT IN (SELECT nomMaison,duree FROM typeMaison)');
        
        DB::statement('INSERT INTO maison (idTypeMaison,description,surface)
        SELECT DISTINCT t.idTypeMaison,im.description,im.surface
        FROM importMaisonTravaux im 
        LEFT JOIN typeMaison t on t.nomMaison = im.typeMaison
        WHERE (t.idTypeMaison,im.description,im.surface) NOT IN (SELECT idTypeMaison,description,surface FROM maison)');

        DB::statement('INSERT INTO travaux (designation,numero,pu,unite)
        SELECT DISTINCT im.typeTravaux, im.codeTravaux,im.prixUnitaire,im.unite
        FROM importMaisonTravaux im
        WHERE (im.typeTravaux, im.codeTravaux,im.prixUnitaire,im.unite) NOT IN (SELECT designation,numero,pu,unite FROM travaux)');

        DB::statement('INSERT INTO devis (idTypeMaison)
        SELECT DISTINCT t.idTypeMaison
        FROM importMaisonTravaux im
        INNER JOIN typeMaison t on t.nomMaison = im.typeMaison
        WHERE (im.typeMaison) NOT IN (SELECT idTypeMaison FROM devis)');

        DB::statement('INSERT INTO devisDetails (idDevis,idTravaux,quantite,pu,prixTotal)
        SELECT distinct d.idDevis,t.idTravaux,im.quantite,im.prixUnitaire,im.prixUnitaire*im.quantite
        FROM importMaisonTravaux im
        INNER JOIN travaux t ON t.numero = im.codeTravaux
        INNER JOIN typeMaison tm ON tm.nomMaison = im.typeMaison
        INNER JOIN devis d ON d.idTypeMaison = tm.idTypeMaison
        WHERE (d.idDevis,t.idTravaux,im.quantite,im.prixUnitaire,im.prixUnitaire*im.quantite) NOT IN (
            SELECT idDevis,idTravaux,quantite,pu,prixTotal FROM devisDetails
        )');

        // Importation du fichier devisFile
        $file = request()->file('devisFile');
        $fileContents = file($file->getPathname());

        $row = 0;

        // Importation des données du fichier devisFile
        foreach ($fileContents as $line) {
            $row++;

            // Si c'est la première ligne, sautez-la
            if ($row == 1) {
                continue;
            } 
            
            $data = str_getcsv($line);

            if ($data[4] < 0) {
                // Retourne une erreur ou arrête le processus
                return redirect()->back()->withErrors(['pourcentage' => 'il y a un pourcentage négatif']);
            }

            $data[4] = str_ireplace(',', '.', $data[4]);
            $data[4] = str_replace('%', '', $data[4]);

            $formatdDateDevis = Carbon::createFromFormat('d/m/Y', $data[5])->format('Y-m-d');
            $formatdDateDebut = Carbon::createFromFormat('d/m/Y', $data[6])->format('Y-m-d');

            // Insérer dans la table importDevis
            DB::table('importDevis')->insert([
                'client' => $data[0],
                'refDevis' => $data[1],
                'typeMaison' => $data[2],
                'finition' => $data[3],
                'tauxFinition' => $data[4],
                'dateDevis' =>$formatdDateDevis,
                'dateDebut' =>$formatdDateDebut,
                'lieu' => $data[7],
            ]);
        }

        // Insertion des données dans les autres tables pour le devis
        DB::statement('INSERT INTO client (numero)
        SELECT DISTINCT im.client
        FROM importDevis im
        WHERE (im.client) NOT IN (SELECT numero FROM client)');
        
        DB::statement('INSERT INTO finition (nomFinition,pourcentage)
        SELECT DISTINCT im.finition,im.tauxFinition
        FROM importDevis im
        WHERE (im.finition,im.tauxFinition) NOT IN (SELECT nomFinition,pourcentage FROM finition)');

        DB::statement('INSERT INTO demandeDevis (idTypeMaison,idClient,idFinition,pourcentage,DateDebut,DateFin,DateCreation,lieu,refDevis)
        SELECT DISTINCT t.idTypeMaison,c.idClient,f.idFinition,im.tauxFinition,im.dateDebut,DATE_ADD(im.dateDebut, INTERVAL t.duree DAY),im.dateDevis,im.lieu,im.refDevis
        FROM importDevis im
        INNER JOIN TypeMaison t on t.nomMaison = im.typeMaison
        INNER JOIN Client c on c.numero = im.client
        INNER JOIN Finition f on f.nomFinition = im.finition
        WHERE (t.idTypeMaison,c.idClient,f.idFinition,im.tauxFinition,im.dateDebut,DATE_ADD(im.dateDebut, INTERVAL t.duree DAY),im.dateDevis,im.lieu,im.refDevis) NOT IN (SELECT idTypeMaison,idClient,idFinition,pourcentage,DateDebut,DateFin,DateCreation,lieu,refDevis FROM demandeDevis)');

        return view('html.importDonnee');  
    }
    

    public function importPaiement()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
        $user = Auth::user();
        
        $file = request()->file('paiementFile');
        $fileContents = file($file->getPathname());
        $row = 0;
        foreach ($fileContents as $line) {
            $row++;
    
            // Si c'est la première ligne, sautez-la
            if ($row == 1) {
                continue;
            } 
            
            $data = str_getcsv($line);
    
            if ($data[3] < 0) {
                // Retourne une erreur ou arrête le processus
                return redirect()->back()->withErrors(['montant' => 'il y a un montant négative']);
            }
            $formatdDatePaiement = Carbon::createFromFormat('d/m/Y', $data[2])->format('Y-m-d');
            // Insérer dans la base de données
            DB::table('importPaiement')->insert([
                'refDevis' => $data[0],
                'refPaiement' => $data[1],
                'datePaiement' => $formatdDatePaiement,
                'montant' => $data[3],
                
            ]);
        }
        
        DB::statement('INSERT INTO historiquePaiement (datePaiement,payer,idDemandeDevis,refDevis,refPaiement)
        SELECT DISTINCT im.datePaiement,im.montant,d.idDemandeDevis,im.refDevis,im.refPaiement
        FROM importPaiement im
        INNER JOIN demandeDevis d ON d.refDevis = im.refDevis
        WHERE (im.datePaiement,im.montant,d.idDemandeDevis,im.refDevis,im.refPaiement) NOT IN (SELECT datePaiement,payer,idDemandeDevis,refDevis,refPaiement FROM historiquePaiement)');
        
        return view('html.importDonnee');  
    }


    // public function importCsv()
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login'); 
    //     }
    //     $user = Auth::user();
        
    //     $file = request()->file('maisonTravauxFile');
    //     $fileContents = file($file->getPathname());
    //     // dd($fileContents);
    //     $row = 0;
    //     foreach ($fileContents as $line) {
    //         $row++;
    
    //         // Si c'est la première ligne, sautez-la
    //         if ($row == 1) {
    //             continue;
    //         } 
            
    //         $data = str_getcsv($line);
    
    //         if ($data[6] < 0) {
    //             // Retourne une erreur ou arrête le processus
    //             return redirect()->back()->withErrors(['prix' => 'il y a un prix négative']);
    //         }
    //         // $data[1] = str_ireplace(',', '.', $data[1]);
    //         $data[2] = str_ireplace(',', '.', $data[2]);
    //         $data[5] = str_ireplace(',', '.', $data[5]);
    //         $data[6] = str_ireplace(',', '.', $data[6]);
    //         $data[7] = str_ireplace(',', '.', $data[7]);
    //         // dd($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]);
    //         // Insérer dans la base de données
    //         DB::table('importMaisonTravaux')->insert([
    //             'typeMaison' => $data[0],
    //             'description' => $data[1],
    //             'surface' => $data[2],
    //             'codeTravaux' => $data[3],
    //             'typeTravaux' => $data[4],
    //             'unite' => $data[5],
    //             'prixUnitaire' => $data[6],
    //             'quantite' => $data[7],
    //             'dureeTravaux' => $data[8],
    //         ]);
    //         // dd($data[0], $description, $data[2], $data[3], $data[4], $data[5], $prixUnitaire, $data[7], $data[8]);
    //     }
        
    //     DB::statement('INSERT INTO typeMaison (nomMaison,duree)
    //     SELECT DISTINCT im.typeMaison, im.dureeTravaux
    //     FROM importMaisonTravaux im
    //     WHERE (im.typeMaison, im.dureeTravaux) NOT IN (SELECT nomMaison,duree FROM typeMaison)');
        
    //     DB::statement('INSERT INTO maison (idTypeMaison,description,surface)
    //     SELECT DISTINCT t.idTypeMaison,im.description,im.surface
    //     FROM importMaisonTravaux im 
    //     LEFT JOIN typeMaison t on t.nomMaison = im.typeMaison
    //     WHERE (t.idTypeMaison,im.description,im.surface) NOT IN (SELECT idTypeMaison,description,surface FROM maison)');

    //     DB::statement('INSERT INTO travaux (designation,numero,pu,unite)
    //     SELECT DISTINCT im.typeTravaux, im.codeTravaux,im.prixUnitaire,im.unite
    //     FROM importMaisonTravaux im
    //     WHERE (im.typeTravaux, im.codeTravaux,im.prixUnitaire,im.unite) NOT IN (SELECT designation,numero,pu,unite FROM travaux)');

    //     DB::statement('INSERT INTO devis (idTypeMaison)
    //     SELECT DISTINCT t.idTypeMaison
    //     FROM importMaisonTravaux im
    //     INNER JOIN typeMaison t on t.nomMaison = im.typeMaison
    //     WHERE (im.typeMaison) NOT IN (SELECT idTypeMaison FROM devis)');

    //     DB::statement('INSERT INTO devisDetails (idDevis,idTravaux,quantite,pu,prixTotal)
    //     SELECT distinct d.idDevis,t.idTravaux,im.quantite,im.prixUnitaire,im.prixUnitaire*im.quantite
    //     FROM importMaisonTravaux im
    //     INNER JOIN travaux t ON t.numero = im.codeTravaux
    //     INNER JOIN typeMaison tm ON tm.nomMaison = im.typeMaison
    //     INNER JOIN devis d ON d.idTypeMaison = tm.idTypeMaison
    //     WHERE (d.idDevis,t.idTravaux,im.quantite,im.prixUnitaire,im.prixUnitaire*im.quantite) NOT IN (
    //         SELECT idDevis,idTravaux,quantite,pu,prixTotal FROM devisDetails
    //     )');

    //     return view('html.importDonnee');  
    // }

    // public function importDevis()
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login'); 
    //     }
    //     $user = Auth::user();
        
    //     $file = request()->file('devisFile');
    //     $fileContents = file($file->getPathname());
    //     // dd($fileContents);
    //     $row = 0;
    //     foreach ($fileContents as $line) {
    //         $row++;

    //         // Si c'est la première ligne, sautez-la
    //         if ($row == 1) {
    //             continue;
    //         } 
            
    //         $data = str_getcsv($line);

    //         if ($data[4] < 0) {
    //             // Retourne une erreur ou arrête le processus
    //             return redirect()->back()->withErrors(['pourcentage' => 'il y a un pourcentage négative']);
    //         }
    //         $data[4] = str_ireplace(',', '.', $data[4]);
    //         $data[4] = str_replace('%', '', $data[4]);

    //         $formatdDateDevis = Carbon::createFromFormat('d/m/Y', $data[5])->format('Y-m-d');
    //         $formatdDateDebut = Carbon::createFromFormat('d/m/Y', $data[6])->format('Y-m-d');

    //         // Insérer dans la base de données
    //         DB::table('importDevis')->insert([
    //             'client' => $data[0],
    //             'refDevis' => $data[1],
    //             'typeMaison' => $data[2],
    //             'finition' => $data[3],
    //             'tauxFinition' => $data[4],
    //             'dateDevis' =>$formatdDateDevis,
    //             'dateDebut' =>$formatdDateDebut,
    //             'lieu' => $data[7],
    //         ]);
    //     }
    //     DB::statement('INSERT INTO client (numero)
    //     SELECT DISTINCT im.client
    //     FROM importDevis im
    //     WHERE (im.client) NOT IN (SELECT numero FROM client)');
        
    //     DB::statement('INSERT INTO finition (nomFinition,pourcentage)
    //     SELECT DISTINCT im.finition,im.tauxFinition
    //     FROM importDevis im
    //     WHERE (im.finition,im.tauxFinition) NOT IN (SELECT nomFinition,pourcentage FROM finition)');

    //     DB::statement('INSERT INTO demandeDevis (idTypeMaison,idClient,idFinition,DateDebut,DateFin,DateCreation,lieu,refDevis)
    //     SELECT DISTINCT t.idTypeMaison,c.idClient,f.idFinition,im.tauxFinition,im.dateDebut,DATE_ADD(im.dateDebut, INTERVAL t.duree DAY),im.dateDevis,im.lieu,im.refDevis
    //     FROM importDevis im
    //     INNER JOIN TypeMaison t on t.nomMaison = im.typeMaison
    //     INNER JOIN Client c on c.numero = im.client
    //     INNER JOIN Finition f on f.nomFinition = im.finition
    //     WHERE (t.idTypeMaison,c.idClient,f.idFinition,im.tauxFinition,im.dateDebut,DATE_ADD(im.dateDebut, INTERVAL t.duree DAY),im.dateDevis,im.lieu,im.refDevis) NOT IN (SELECT idTypeMaison,idClient,idFinition,DateDebut,DateFin,DateCreation,lieu,refDevis FROM demandeDevis)');


    //     return view('html.importDonnee');  
    // }
}
