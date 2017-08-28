<?php

namespace App\Http\Middleware;

use Closure;

class Time
{

    public function handle($request, Closure $next)
    {
        if(time()<strtotime('2017-07-07')){
            return redirect()->route('mysql');
           
        }
        else
            return $next($request);
    }
}
