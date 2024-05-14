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

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
        $user = Auth::user();
        
        return view('html.index', ['user' => $user]);  
    }

    public function admin()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
        
        $user = Auth::user();
        
        $prixDevis = DB::table('ViewListeDevis_Paiement')->get();
        $prixTotal = $prixDevis->sum('prixTotal');

        $prixTotalDevis = DB::table('ViewDevisMois')->get();
        
        return view('html.admin', ['user' => $user, 'prixTotal' => $prixTotal, 'prixTotalDevis' => $prixTotalDevis]);   
    }

    public function user()
    {
        $client = session('client');
        if (!$client) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        $prixMaisons = DB::table('prixMaison')->get();
        return view('html.index', ['prixMaisons' => $prixMaisons, 'client' => $client]);
    }
    public function loginClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $client = Client::where('numero', $request->numero)->first();
        if (!$client) {
            return redirect()->back()->withErrors(['numero' => 'Le numéro de client est incorrect'])->withInput();
        }
        
        Session::put('client', $client);
        $prixMaisons=DB::table('prixMaison')->get();
        return view('html.index',['prixMaisons'=>$prixMaisons]);  

    }

    // public function user()
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login'); 
    //     }
      
    //     $user = Auth::user();
        
    //     return view('html.index', ['user' => $user]);
    // }
    public function reset()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $tables = [
            'users',
            'test2',
            'test',
        ];

        foreach ($tables as $table) {
            if ($table === 'users') {
                User::where('status', '!=', 'admin')->delete();
            } else {
                DB::table($table)->truncate();
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');


        return redirect()->back()->with('success', 'La base de données a été réinitialisée avec succès.');
    }
}
