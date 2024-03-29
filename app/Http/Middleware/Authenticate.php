<?php

namespace App\Http\Middleware;

use App\Models\Teacher;
Use Closure;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if($request->is('teacher/*')){
           return route('teacher.login');
        }else{
            return route('student.login');
        }
    }
}
    

