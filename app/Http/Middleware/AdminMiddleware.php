<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = Auth::user()->role;
        $perm = Auth::user()->permission;
        if ($role != 'admin') {
            return redirect()->back()->with('err', 'You dont have permission to view that resource.');
        }
        return $next($request);
    }
}
