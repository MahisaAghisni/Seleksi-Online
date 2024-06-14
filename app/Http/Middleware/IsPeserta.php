<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPeserta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if (session()->get('role') !== 3) {
        //     return redirect('/');
        // }

        if (auth()->guard('peserta')->check() && session()->get('role') !== 3) {
            return redirect('/');
        }

        return $next($request);
    }
}
