<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
     

        return $next($request)
        //Url a la que se le dará acceso en las peticiones
       ->header("Access-Control-Allow-Origin", "*")
       ->header("Allow-Control-Allow-Origin", "*")
       ->header("Access-Control-Allow-Credentials", "false")
       //Métodos que a los que se da acceso
       ->header("Access-Control-Allow-Methods", "*")
       //Headers de la petición
       ->header("Access-Control-Allow-Headers", "*"); 
       
    }
}
