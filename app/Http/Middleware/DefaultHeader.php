<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class DefaultHeader
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle (Request $request, Closure $next) : Response|RedirectResponse|JsonResponse
    {
//        var_dump(get_class($next($request)));
//        die();
        return $next($request)->header('Content-Type', 'application/json')
                              ->header('Access-Control-Expose-Headers', 'Authorization')
                              ->header('Access-Control-Allow-Headers', 'Authorization')
                              ->header('Access-Control-Allow-Methods',
                                       'HEAD, GET, POST, PUT, DELETE')
                              ->header('Access-Control-Allow-Headers', 'origin, x-requested-with')
                              ->header('Access-Control-Allow-Origin', '*')
                              ->header('Expires',
                                       (new DateTime('+5 seconds'))->format('D, d M Y H:i:s T'));
    }
}
