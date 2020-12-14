<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
 //import auth facades prov - po bon
 use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;

class InstructorsController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:instructor-api', ['except' => ['login','register']]);
    }



    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:instructors',
            'password' => 'required',
        ]);
   
        try {
   
            $instructor = new Instructor;
            $instructor->name = $request->input('name');
            $instructor->email = $request->input('email');
            $plainPassword = $request->input('password');
            $instructor->password = app('hash')->make($plainPassword);
   
            $instructor->save();
   
            //return successful response
            return response()->json(['instructor' => $instructor, 'message' => 'CREATED'], 201);
   
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
        ]);

        $credentials = $request->only(['email', 'password']);
        $instructor = Instructor::where('email', $request->input('email'))->first();

        if (! $token = Auth::guard('instructor-api')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
     

   
  

    public function mee()
    {   

    
        return response()->json(auth('instructor-api')->user());
    }


}

