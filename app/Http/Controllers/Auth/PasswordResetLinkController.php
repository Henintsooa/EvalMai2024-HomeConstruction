<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash; // Ajout de Hash
use App\Models\User; // Ajout de l'import du modèle User


class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'], 
        ]);
        // Trouver l'utilisateur correspondant à l'e-mail fourni
        $user = User::where('email', $request->email)->first();

        // Si l'utilisateur existe
        if ($user) {
            // Mettre à jour le mot de passe de l'utilisateur
            $user->password = Hash::make($request->password);
            $user->save();

            // Envoyer un message de succès
            return back()->with('status', 'Mot de passe changé avec succèss!');
        } else {
            // Si l'utilisateur n'existe pas, envoyer un message d'erreur
            return back()->withErrors(['email' => 'email non retrouvé.']);
        }
        // // We will send the password reset link to this user. Once we have attempted
        // // to send the link, we will examine the response then see the message we
        // // need to show to the user. Finally, we'll send out a proper response.
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );

        // return $status == Password::RESET_LINK_SENT
        //             ? back()->with('status', __($status))
        //             : back()->withInput($request->only('email'))
        //                     ->withErrors(['email' => __($status)]);
    }
}
