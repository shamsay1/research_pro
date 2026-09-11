<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthentication
{
    public function handle(
        Request $request,
        Closure $next,
        ...$guards
    ): Response {

        // Kama hakuna guard iliyotumwa
        if (empty($guards)) {
            $guards = ['web'];
        }

        // Angalia kila guard
        foreach ($guards as $guard) {

            if (auth()->guard($guard)->check()) {
                return $next($request);
            }
        }

        // Hakuna aliye-login
        return redirect()
            ->route('login1')
            ->with('error', 'Please login.');
    }
}