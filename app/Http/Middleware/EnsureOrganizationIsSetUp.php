<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizationIsSetUp
{
    // Reachable before setup is finished: the setup itself, signing in and out, and password resets
    private const ALWAYS_ALLOWED = [
        'setup', 'setup.*', 'login', 'logout', 'password.*', 'denied',
    ];

    /**
     * Until the organization's details have been saved, send admins to the setup page
     * and tell everyone else that the system is not ready yet.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Before the settings table exists (migration not run yet), don't lock the site
        if (!Organization::tableExists() || Organization::isSetUp() || $request->routeIs('setup', 'setup.*')) {
            return $next($request);
        }

        $user = $request->user();

        // Brand-new install with no accounts at all: nobody can sign in yet, and the setup page creates the first admin
        if (!$user && !User::query()->exists()) {
            return redirect()->route('setup');
        }

        if ($request->routeIs(...self::ALWAYS_ALLOWED)) {
            return $next($request);
        }

        // Guests go through the normal sign-in flow first
        if (!$user) {
            return $next($request);
        }

        if ($user->role == 1) {
            return redirect()->route('setup');
        }

        return response()->view('setup.pending', [], 503);
    }
}
