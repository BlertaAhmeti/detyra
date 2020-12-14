<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
 //import auth facades 
 use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

 //veq prov - po bbon
 public function register(Request $request)
 {
     //validate incoming request 
     $this->validate($request, [
         'name' => 'required|string',
         'email' => 'required|email|unique:users',
         'password' => 'required',
     ]);

     try {

         $user = new User;
         $user->name = $request->input('name');
         $user->email = $request->input('email');
         $plainPassword = $request->input('password');
         $user->password = app('hash')->make($plainPassword);

         $user->save();

         //return successful response
         return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

     } catch (\Exception $e) {
         //return error message
         return response()->json(['message' => 'User Registration Failed!'], 409);
     }

 }







// nni form tjeter e login
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {

            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'));
    }


    //veq prov
    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


   public function logout(){
       auth()->logout();
       return response()->json(['msg'=>'user logged out successfully']);
   }

    public function me()
    {
        return response()->json(auth()->user());
    }
}