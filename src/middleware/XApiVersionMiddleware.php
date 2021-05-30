<?php

namespace Cryptolib\CryptoCore\Middleware;

use Closure;
use Illuminate\Http\Request;

class XApiVersionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $version)
    {
        if (!$request->hasHeader("X-API-VERSION"))
            return response()->json((object)[
                "code" => 415,
                "detail" => "Need Api version",
                "title" => "Подключение к маршруту"
            ]);

        if ($request->header("X-API-VERSION") != $version)
            return response()->json((object)[
                "code" => 415,
                "detail" => "Bad Api version, required $version",
                "title" => "Подключение к маршруту"
            ]);

        return $next($request);
    }
}
