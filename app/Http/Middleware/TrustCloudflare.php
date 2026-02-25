<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustCloudflare
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cloudflare/Proxy : si la requête arrive via HTTPS côté client
        $proto = $request->header('x-forwarded-proto');
        $host  = $request->header('x-forwarded-host');

        if ($proto === 'https') {
            $request->server->set('HTTPS', 'on');
            $request->server->set('SERVER_PORT', 443);
        }

        // Fix host (important pour URLs/signatures)
        if ($host) {
            $request->server->set('HTTP_HOST', $host);
            $request->server->set('SERVER_NAME', $host);
        }

        return $next($request);
    }
}