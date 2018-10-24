<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next) {
    $serverKey = env('API_SERVER_KEY');
    if ($request->getHost() === env('APP_HOST') && strlen($serverKey) > 0 && $request->header('X-API-KEY') === $serverKey) {
      return $next($request);
    }
    return response()->json(['error' => 'Unauthorized'], 401);
  }
}
