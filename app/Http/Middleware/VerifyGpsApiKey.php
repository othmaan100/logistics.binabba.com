<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyGpsApiKey
{
    /**
     * Only let trackers that send the shared X-API-Key header through.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('services.gps.key');
        $given = (string) $request->header('X-API-Key');

        // An unset key locks the endpoint rather than leaving it open
        if ($expected === '' || !hash_equals($expected, $given)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
