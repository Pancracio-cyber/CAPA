<?php

namespace App\Http\Middleware;

use Closure;

class token
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
        
        if (!$request->has("ews_token")) {
            return response()->json([
              'wsp_mensaje' => 'La solicitud no fue válida',
            ], 400);
          }
      
          if ($request->has("ews_token")) {
            $api_key = "fnPqT5xQEi5Vcb9wKwbCf65c3BjVGyBB";
            if ($request->input("ews_token") != $api_key) {
              return response()->json([
                'wsp_mensaje' => 'TOKEN Inválido o Inexistente',
              ], 403);
            }
          }
        return $next($request);
    }
}
