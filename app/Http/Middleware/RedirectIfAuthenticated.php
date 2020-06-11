<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Teacher;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //Kind of awful, not sure if this behavior is even desirable. Maybe change?
        if (Auth::guard($guard)->check() ) {
            if($request->is('teacher/login')){
                return redirect(RouteServiceProvider::TEACHER_HOME);
            }else{
                return redirect(RouteServiceProvider::STUDENT_HOME);
            }
        }

        return $next($request);
    }
}
