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
use App\Models\travaux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;    
use Illuminate\Support\Facades\Validator;

class TravauxController extends Controller
{
    public function travaux()
    {
        $travaux = travaux::all();
        return view('html.travaux',['travaux'=>$travaux]);  
    }

    public function updateTravaux($idTravaux)
    {
        $travaux = travaux::find($idTravaux);        
        return view('html.updateTravaux',['travaux'=>$travaux]);  
    }

    public function editTravaux(Request $request) {
        $validator = $request->validate([
            'designation' => 'required|string',
            'numero' => 'required|string',
            'pu' => 'required|string',
            'unite' => 'required|string',
        ], [
            'designation.required' => 'La designation est requis.',
            'numero.required' => 'Le numero est requis.',
            'pu.required' => 'Le prix unitaire est requis.',
            'unite.required' => 'L\'unnite est requis.',
            
        ]);

        DB::table('travaux')
            ->where('idTravaux', $request->idTravaux)
            ->update([
                'designation' => $request->designation,
                'numero' => $request->numero,
                'pu' => $request->pu,
                'unite' => $request->unite
            ]);
    
        return redirect()->back()->with('success', 'Les modifications ont été enregistrées avec succès.');
    }
}
