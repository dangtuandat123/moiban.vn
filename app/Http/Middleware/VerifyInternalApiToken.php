<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: Xác thực Internal API bằng secret token
 */
class VerifyInternalApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-Internal-Token');
        $expectedToken = config('services.internal_api.secret');

        if (empty($expectedToken)) {
            abort(500, 'Internal API secret not configured');
        }

        if ($token !== $expectedToken) {
            abort(401, 'Invalid API token');
        }

        return $next($request);
    }
}
