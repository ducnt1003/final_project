<?php

namespace App\Http\Middleware;

use App\Services\BaseService;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected $baseService;
    protected $auth;

    public function __construct(BaseService $baseService,Auth $auth)
    {
        $this->baseService = $baseService;
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if(is_null($request->header('authorization'))){
            return $this->baseService->sendError('Authorization failed, without authorization', __('admin.message.error'),JsonResponse::HTTP_UNAUTHORIZED);
        };
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if(!$user){
                return $this->baseService->sendError(__('auth.login.unauthorize'), __('admin.message.error'),JsonResponse::HTTP_UNAUTHORIZED);
            }
        }catch (TokenInvalidException $exception) {
            Log::error($exception);
            return $this->baseService->sendError(__('auth.login.unauthorize'), __('admin.message.error'),JsonResponse::HTTP_UNAUTHORIZED);
        }
        catch (TokenExpiredException|JWTException $exception) {
            Log::error($exception);
            return $this->baseService->sendError(__('auth.login.unauthorize'), __('admin.message.error'),JsonResponse::HTTP_UNAUTHORIZED);
        };

       $this->authenticate($request, $guards);

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

}
