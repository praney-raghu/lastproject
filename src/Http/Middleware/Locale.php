<?php

namespace Ssntpl\Neev\Http\Middleware;

use Closure;
use App;
use Config;

class Locale
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
        if(session()->has('language'))
        {
            $lang = session()->get('language');
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
