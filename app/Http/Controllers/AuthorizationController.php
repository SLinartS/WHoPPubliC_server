<?php

namespace App\Http\Controllers;

use App\Services\Authorization as ServicesAuthorization;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class AuthorizationController extends Controller
{
  public function login(Request $request, ServicesAuthorization $servicesAuthorization)
  {
    try {
      $response = $servicesAuthorization->login($request->login, $request->password);

      if (count($response['errors'])) {
        return response()->json($response, 404);
      }

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th->getMessage(), 404);
    }
  }

  public function refresh(Request $request, ServicesAuthorization $servicesAuthorization)
  {
    $refreshToken = $request->refreshToken;

    try {
      if (!$refreshToken) {
        throw new Exception('refresh token not detected');
      }

      $response = $servicesAuthorization->refresh($refreshToken);

      return response()->json($response, 200);
    } catch (\Throwable $th) {
      return response($th, 500);
    }
  }

  public function logout(Request $request, ServicesAuthorization $servicesAuthorization)
  {
    $accessToken = $request->header('Authorization');
    $userId = $request->userId;
    try {
      if (!$accessToken) {
        throw new Exception('token not found');
      }
      $accessToken = substr($accessToken, 7);
      $servicesAuthorization->logout($accessToken, $userId);
      return response()->json(['message' => 'logged out']);
    } catch (\Throwable $th) {
      return response($th->getMessage(), 500);
    }
  }
}
