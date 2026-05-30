<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsManager
{
   
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'manager'){
            abort(403,'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        return $next($request);
    }
}
