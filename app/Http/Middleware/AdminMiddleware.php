<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try{


       $user = JWTAuth::parseToken()->authenticate();

       if($user->role_ID == 2)
       {

         return $this->returnError("E003","Sorry! You are Not Admin");

       }
       else
       {
         return $next($request);
       }
    }catch (Exception $e) {

        if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

            return $this->returnError("E005","Token is Invalid");

        }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

            return $this->returnError("E006","Token is Expired");


        }else{

            return $this->returnError("E007","Authorization Token not found");

        }
    }
}
}
