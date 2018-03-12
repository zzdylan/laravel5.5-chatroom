<?php

namespace App\Http\Middleware;

use Closure;

class Cors {

    /**
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers:Authorization,Origin, X-Requested-With, Content-Type, Accept");
        header("Access-Control-Allow-Credentials:false");
        header('Access-Control-Allow-Methods:GET,POST,PATCH,PUT,OPTIONS');
        return $next($request);
    }

}
