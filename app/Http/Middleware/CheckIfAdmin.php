<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckIfAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect to login page if not authenticated
            return redirect()->route('filament.auth.login');
        }

        // Check if the user is an admin
        if (!Auth::user()->admin) {
            // Optionally, you can logout the user
            Auth::logout();

            // Redirect to login page with an error message 
            return redirect()->route('filament.auth.login')->withErrors([
                'email' => 'You are not authorized to access the admin panel.',
            ]);
        }

        // Proceed with the request
        return $next($request);
    }
}
