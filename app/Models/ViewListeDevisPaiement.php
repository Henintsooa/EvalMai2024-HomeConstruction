<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewListeDevisPaiement extends Model
{
    use HasFactory;
    protected $table = 'ViewListeDevis_Paiement';
    protected $fillable = ['idMaison','idFinition','nomFinition','pourcentage','DateDebut','DateFin','idDemandeDevis',
    'idClient','numero','prixDevisTotal','idDevis','prixTotal','payer','resteAPayer','etatPaiement'];


}