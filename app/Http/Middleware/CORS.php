<?php

namespace App\Http\Middleware;

use Closure;

class CORS {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next) {
    if ($request->isMethod('options')) {
      return $this->addCORSHeaders(response(null, 204));
    }

    return $this->addCORSHeaders($next($request));
  }

  private function addCORSHeaders($response) {
    return $response
      ->header('Access-Control-Allow-Origin', env('CORS_ORIGIN', 'https://cgcu.net'))
      ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
      ->header('Access-Control-Allow-Headers', 'X-API-Key, Content-Type');
  }
}
