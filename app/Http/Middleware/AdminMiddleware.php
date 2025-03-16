<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié et s'il est admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Rediriger si l'utilisateur n'est pas admin
        return redirect('/')->with('error', 'Accès refusé.');
    }
}
