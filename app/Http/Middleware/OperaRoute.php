<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class OperaRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {

        if ($this->auth->getUser()->role !== "administrator" && $this->auth->getUser()->role !== "developer" && $this->auth->getUser()->role !== "operations") {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
