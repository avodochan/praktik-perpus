<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->user(); //cek user yang login
        if ($user->role === 'koordinator') 
        {
            return $next($request);
        }
        //jika user role adalah admin
        elseif($user->role === 'admin')
        {
            return $next($request);
        }
        //jika user role yang login adalah user (member)
        elseif($user->role === 'user')
        {
            return $next($request);
        }
        //jika tidak ketiganya
        else {
            return redirect()->back();
        }
    }
}
