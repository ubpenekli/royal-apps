<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QtestsAuthentication
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
        if (session('user') === null) {
            return redirect()->route('login_view')->with('error', 'You must login before continuing.');
        } else {
            $user = session('user');
            if (Carbon::parse($user->expires_at)->isPast()) {
                return redirect()->route('login_view')->with('error', 'You must re-login before continuing.');
            }
        }
        return $next($request);
    }
}
