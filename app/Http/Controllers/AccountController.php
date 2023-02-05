<?php

namespace App\Http\Controllers;

use App\Services\Account as ServicesAccount;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(ServicesAccount $servicesAccount) {
      $response = $servicesAccount->index();

      return response()->json($response, 200);
    }
}
