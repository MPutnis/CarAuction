<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCreditCardVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('login')->with('error', 'Please login to access this page.');
        }

        if (!$user->credit_card_verified) {
            return redirect('/')->with('error', 'Please verify your credit card to access this page.');
        }
        
        return $next($request);
    }
}
