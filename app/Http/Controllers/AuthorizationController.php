<?php

namespace App\Http\Controllers;

use App\Services\Authorization as ServicesAuthorization;
use Illuminate\Http\Request;
use Throwable;

class AuthorizationController extends Controller
{
  public function login(Request $request, ServicesAuthorization $servicesAuthorization)
  {
    try {
      $response = $servicesAuthorization->login($request->login, $request->password);
      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th->getMessage(), 401);
    }
  }

  public function logout(Request $request)
  {
    $request->user()->currentAccessToken()->delete();

    return response('account logout completed', 200);
  }
}
