<?php

namespace App\Http\Middleware\Pages;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuratMasukMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->isPengolah() || Auth::user()->isKadin())) {
            return $next($request);
        } else {
            if (Auth::guest()) {
                return redirect()->guest(route('home'))
                    ->with('expire', 'Halaman yang Anda minta memerlukan otentikasi, silahkan masuk ke akun Anda.');
            }
        }

        return abort(403);
    }
}
