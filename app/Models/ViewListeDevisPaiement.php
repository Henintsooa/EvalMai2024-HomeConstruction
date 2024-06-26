<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewListeDevisPaiement extends Model
{
    use HasFactory;
    protected $table = 'ViewListeDevis_Paiement';
    protected $fillable = ['idTypeMaison','nomMaison','idFinition','nomFinition','lieu','pourcentage','DateCreation','DateDebut','DateFin','idDemandeDevis',
    'idClient','numero','prixDevisTotal','idDevis','prixTotal','prixPourcentage','payer','resteAPayer','etatPaiement','pourcentagePaye'];


}
