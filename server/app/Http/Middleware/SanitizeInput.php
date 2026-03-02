<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        // Limpia recursivamente todos los campos de entrada
        array_walk_recursive($input, function(&$item) {
            // strip_tags elimina etiquetas HTML y PHP como <script>
            $item = is_string($item) ? strip_tags($item) : $item;
        });

        $request->merge($input);
        return $next($request);
    }
}
