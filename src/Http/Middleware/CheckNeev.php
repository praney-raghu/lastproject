<?php

namespace Ssntpl\Neev\Http\Middleware;

use Closure;
use Ssntpl\Neev\Facades\Neev;

class CheckNeev
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
        if (!Neev::isInstalled() && !($request->is(config('neev.install_route') . '/*') || $request->is(config('neev.install_route')) )) {
            return redirect(config('neev.install_route'));
        }

        if (Neev::isInstalled() && ($request->is(config('neev.install_route') . '/*') || $request->is(config('neev.install_route')) )) {
            return redirect('/');
        }

        if (Neev::isInstalled() && !Neev::isRegistered() && !$request->is(config('neev.organisation_not_found_route'))) {
            return redirect(config('neev.organisation_not_found_route'));
        }

        if (Neev::isInstalled() && Neev::isRegistered() && $request->is(config('neev.organisation_not_found_route'))) {
            return redirect('/');
        }


        return $next($request);
    }
}
