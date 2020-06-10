<?php

namespace App\Http\Middleware;

use DB;
use Closure;

class LastOnlineAt
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
        if (auth()->guest()) {
            return $next($request);
        }
        if (empty(auth()->user()->last_login)) {
            DB::table("users")
              ->where("id", auth()->user()->id)
              ->update(["last_login" => now()]);
        }
        elseif (auth()->user()->last_login->diffInHours(now()) !==0)
        { 
            DB::table("users")
              ->where("id", auth()->user()->id)
              ->update(["last_login" => now()]);
        }

        return $next($request);
    }
}
