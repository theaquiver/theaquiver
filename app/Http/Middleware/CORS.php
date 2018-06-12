<?php

namespace App\Http\Middleware;

use Closure;

class CORS
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
        header("Access-Control-Allow-Origin: http://theaquiver.xyz");
        $headers = [
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization'
        ];
        if ($request->getMethod() == "OPTIONS") {
            return \Response::make('OK', 200, $headers);
        }
        // if ($request->header('Authorization') != 'gsrxit6pQDjlpr4IofeOmEtZUdKfZSgG6lEczj') {
        //     return redirect('/');
        // }
        $response = $next($request);
        foreach ($headers as $key => $value)
            $response->header($key, $value);
        return $response;
        return $next($request);
    }
}
