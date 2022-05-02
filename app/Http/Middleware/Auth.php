<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Auth
{
    public function handle($request, Closure $next)
    {
        // Perform action
        $session = Session::get('admin') ?? null;
        if ( $session == null) {
            return redirect('/administrator/get-sign-in');
        }

        return $next($request);
    }
}
