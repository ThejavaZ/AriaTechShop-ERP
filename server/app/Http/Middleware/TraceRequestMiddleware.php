<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Ramsey\Uuid\Uuid;

class TraceRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = $request->headers->get('X-Trace-ID') ?? Uuid::uuid4()->toString();

        $request->merge(['trace_id' => $traceId]);

        Log::context(['trace_id' => $traceId]);

        $response = $next($request);

        $response->headers->set('X-Trace-ID', $traceId);

        return $response;
    }
}