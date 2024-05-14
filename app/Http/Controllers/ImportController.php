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
        
        return view('html.importDonnee');  
    }
}
