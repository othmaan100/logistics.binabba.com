<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // return $next($request);
        $user = $request->user();
        //dd($user);
        // Check if the user has the required role
        if ($user && $user->role ==1) {
            return $next($request);
        }

        return redirect()->route("denied");
    }
}
