<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyUser
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

        $user = User::findOrFail(Auth::user()->id);

        if (!$user->verify) {
            Auth::guard()->logout();
            $request->session()->invalidate();
            session()->flash('error','Your Number Is Not Verified. Goto verification point.');
            return redirect()->route('login');
        }
        else if ($user->status) {
            Auth::guard()->logout();
            $request->session()->invalidate();
            session()->flash('error','You Have Already Voted.');
            return redirect()->route('login');
        }



        return $next($request);
    }
}
