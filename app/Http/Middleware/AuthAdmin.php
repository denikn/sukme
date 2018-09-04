<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
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

        if (! Auth::guard('admin')->check()) {

           Auth::logout();
           return redirect('/login/admin');
           
        }
        
        $user = Auth::user();

        if($user->user_type !== 'admin'){
            
            Auth::logout();
            return redirect('/login/admin');

        }

        return $next($request);
    }
}
