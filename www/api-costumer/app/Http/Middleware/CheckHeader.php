<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseAPI;
use Closure;

class CheckHeader
{
    use ResponseAPI;
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */

    protected $exceptRoutes = [
        
    ];

    public function handle(Request $request, Closure $next)
    {
        $header = !$request->hasHeader('Accept') && !$request->hasHeader('Content-Type');
        $headerlowercase = !$request->hasHeader('accept') && !$request->hasHeader('content-Type');
        $acceptHeader = $header || $headerlowercase;

        if($acceptHeader) {
            return $this->error('Must Be add header Accept: application/json',[],403);
        }
        if(in_array($request->path(), $this->exceptRoutes)) {
            return $this->error('API Not Found',[],404);
        }
        return $next($request);
    }
}
