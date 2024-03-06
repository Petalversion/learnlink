<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class InstructorMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'instructor') {
            return $next($request);
        }

        // If the user is not authenticated as an instructor, you can handle the logic here, such as redirecting to a login page or denying access.
        return redirect('/');
    }
}
