<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
  //import auth facades
  use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    //

  //Add this method to the Controller class , kjo ta jep token per krejt kontrollerat
  //this will return access token
   
  protected function respondWithToken($token)
  {
      return response()->json([
           'Pershendetje'=>'ju jeni kyqur ne llogarin tuaj',
          'token' => $token,
          'token_type' => 'bearer',
          'expires_in' => Auth::factory()->getTTL() * 60
      ], 200);
  }
  
}
