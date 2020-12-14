<?php

namespace App\Http\Controllers;
use App\Models\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
 //import auth facades prov - po bon
 use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{ /**
    * @var \Tymon\JWTAuth\JWTAuth
    */
   protected $jwt;

   public function __construct()
   {
       $this->middleware('auth:admin-api', ['except' => ['login','register']]);
   }

  
   public function register(Request $request)
   {
       //validate incoming request 
       $this->validate($request, [
           'name' => 'required|string',
           'email' => 'required|email|unique:admins',
           'password' => 'required',
           'code'=>'required'
       ]);
  
       try {
  
           $admin = new Admin;
           $admin->name = $request->input('name');
           $admin->email = $request->input('email');
           $plainPassword = $request->input('password');
           $admin->password = app('hash')->make($plainPassword);
           $admin->code = $request->input('code');
           $admin->save();
  
           //return successful response
           return response()->json(['instructor' => $admin, 'message' => 'CREATED'], 201);
  
       } catch (\Exception $e) {
           //return error message
           return response()->json(['message' => 'Instructor Registration Failed!'], 409);
       }
  
   }
   public function login(Request $request)
   {
         //validate incoming request 
       $this->validate($request, [
           'email' => 'required|string',
           'password' => 'required|string',
           'code'=>'required'
       ]);

       $credentials = $request->only(['email', 'password', 'code']);
       $admin = Admin::where('code', $request->input('code'))->first();

       if (! $token = Auth::guard('admin-api')->attempt($credentials)) {
           return response()->json(['message' => 'Unauthorized'], 401);
       }

       return $this->respondWithToken($token);
   }
    
 

}
