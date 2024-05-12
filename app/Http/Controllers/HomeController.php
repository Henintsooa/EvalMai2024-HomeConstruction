<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
    

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
        
        return view('html.admin', ['user' => $user]);   
    }

    public function user()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
      
        $user = Auth::user();
        
        return view('html.index', ['user' => $user]);
    }
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
