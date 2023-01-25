<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Admin;
use Request;


class DriverAuth
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

        $user=Auth::guard('staff_members')->check();

        if(Auth::guard('staff_members')->check() == false){
            return redirect('driver/login');
        }

        return $next($request);
    }
}
