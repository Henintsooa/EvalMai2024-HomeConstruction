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
use App\Models\finition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;    
use Illuminate\Support\Facades\Validator;

class FinitionController extends Controller
{
    public function finition()
    {
        $finitions = finition::all();
        return view('html.adminFinition',['finitions'=>$finitions]);  
    }

    public function updateFinition($idFinition)
    {
        $finition = finition::find($idFinition);        
        return view('html.updateFinition',['finition'=>$finition]);  
    }

    public function editFinition(Request $request) {
        $validator = $request->validate([
            'nomFinition' => 'required|string',
            'pourcentage' => 'required|string',
        ], [
            'nomFinition.required' => 'Le nom est requis.',
            'pourcentage.required' => 'Le pourcentage est requis.',
           
            
        ]);

        DB::table('finition')
            ->where('idFinition', $request->idFinition)
            ->update([
                'nomFinition' => $request->nomFinition,
                'pourcentage' => $request->pourcentage
            ]);
    
        return redirect()->back()->with('success', 'Les modifications ont été enregistrées avec succès.');
    }

}
