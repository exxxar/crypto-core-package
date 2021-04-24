<?php

namespace Cryptolib\CryptoCore\Middleware;

use Closure;
use Illuminate\Http\Request;

class XApiVersionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $version)
    {
        if (!$request->hasHeader("X-API-VERSION"))
            return response()->json([
               "message"=>"Need Api version"
            ]);

        if ($request->header("X-API-VERSION")!=$version)
            return response()->json([
                "message"=>"Bad Api version, required $version"
            ]);

        return $next($request);
    }
}
