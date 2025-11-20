<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //obtiene el valor del header llamado token-alumplastic y si es diferente al token que tengo en .env devuelve un error "404 Not Found"
        if ($request->header('token-alumplastic') !== config('token_api.token')) {
            abort(404);
        }
        
        return $next($request);
    }
}
