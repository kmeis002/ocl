<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class TeacherMiddleware extends Middleware
{

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('teacher.login');
        }
    }
}