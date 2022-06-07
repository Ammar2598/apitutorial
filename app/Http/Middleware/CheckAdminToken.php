<?php

namespace App\Http\Middleware;

use Closure;
use  Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\GeneralTrait;

class CheckAdminToken
{
    use GeneralTrait; 

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
                //throw an exception
            
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // return response() -> json(['success' => false, 'msg' => 'INVALID _TOKEN']);
                return $this->returnError('E3001','INVALID _TOKEN');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // return response() -> json(['success' =>false, 'msg'=>'EXPIRED_TOKEN']);
                return $this->returnError('E3001','EXPIRED_TOKEN');

            } else{
                // return response() -> json(['success' => false, 'msg' => 'Error']);
                return $this->returnError('E3001','TOKEN_NOTFOUND');

            }
            
        }
        catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // return response() -> json(['success' => false, 'msg' => 'INVALID _TOKEN']);
                return $this->returnError('E3001','INVALID _TOKEN');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // return response() -> json(['success' =>false, 'msg'=>'EXPIRED_TOKEN']);
                return $this->returnError('E3001','EXPIRED_TOKEN');

            } else{
                // return response() -> json(['success' => false, 'msg' => 'Error']);
                return $this->returnError('E3001','TOKEN_NOTFOUND');

            }
            
        }
        
        if(!$user)
                return $this->returnError('E3001','Unauthenticated');
            return $next($request);
    }
}
