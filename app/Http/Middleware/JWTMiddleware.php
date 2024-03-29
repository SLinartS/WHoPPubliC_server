<?php

namespace App\Http\Middleware;

use App\Models\Token as ModelsToken;
use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;

class JWTMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    if ((bool) config('app.dont_use_jwt_auth')) {
      return $next($request);
    }
    $token = $request->header('Authorization');
    if ($token) {
      $token = substr($token, 7);
      if (
        Token::validate($token, config('app.jwt_access_secret')) &&
        ModelsToken::where('access', $token)->first()
      ) {
        if (Token::validateExpiration($token)) {
          return $next($request);
        }
        return response()->json(['message' => 'token expired'], 401);
      }
    }
    return response()->json(['message' => 'token error', 'token' => $token], 401);
  }
}
