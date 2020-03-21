<?php

namespace App\Http\Middleware;

use App\Admin;
use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyAdmin
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

        $user = Admin::findOrFail(Auth::user()->id);

        if (!$user->active) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            session()->flash('error','Your Account Is Blocked.');
            return redirect()->route('admin.login');
        }



        return $next($request);
    }
}
