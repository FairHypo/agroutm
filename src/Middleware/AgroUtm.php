<?php

namespace Fairhypo\Agroutm\Middleware;

use Closure;
use Fairhypo\Agroutm\Controllers\UtmController;

class AgroUtm
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
        $utm_controller = new UtmController();
        $cookies = $utm_controller->index($request);
        $response = $next($request);
        foreach( $cookies as $cookie ) {
            $response = $response->withCookie($cookie);
        }
        return $response;
    }
}
