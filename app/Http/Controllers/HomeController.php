<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Pack;
use App\Models\axe;
use App\Models\lieu;
use App\Models\packDetails;
use App\Models\venteDetails;
use Illuminate\Support\Facades\DB;

    

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
            
            return view('html.index'); 
    }

    public function admin()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
        
        return view('html.index'); 
    }

    public function user()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
      
        return view('html.index'); 
    }

}
