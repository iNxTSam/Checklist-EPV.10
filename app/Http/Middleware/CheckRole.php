<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $role): Response
    {
        if(!Auth::check()|| Auth::user()->Roles_idRoles != $role){
            abort(403, 'Acceso no autorizado');
        }
        return $next($request);
    }
}
