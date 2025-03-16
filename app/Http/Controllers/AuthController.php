<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard'); // Redirection après connexion
        }

        return back()->with('error', 'Email ou mot de passe incorrect.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}