<?php


namespace App\Http\Middleware;

use Closure;


class CheckLogin{



    public function handle($request, closure $next)
    {
        if($request->input('age') <=200)
        {
            return redirect('home');
        }


        return $next($request);
    }
}