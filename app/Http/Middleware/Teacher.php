<?php

namespace App\Http\Middleware;

use Closure;
use Gate;

class Teacher
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
        if (Gate::denies('manage-tasks', auth()->user())) {
            return redirect('home')->with('status', 'Ei vaadittavia käyttöoikeuksia!');
        }

        return $next($request);
    }
}
