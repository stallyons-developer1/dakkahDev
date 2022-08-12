<?php

namespace App\Http\Middleware;

use Closure;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Logs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next )
    {
        $logs = ['URL: '=>$request->fullUrl(),'Method:'=>$request->getMethod(),'Data:'=>$request->all() , 'user_id'=>session()->get('user')['user_id'],'date'=>date('Y-m-d')];
        Log::channel('dakkahlogs')->info(json_encode($logs));

//        dd($request->getMethod());
        return $next($request);
    }
}
