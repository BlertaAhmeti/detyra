<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\EnrollC;
class UserController extends Controller{





    public function enroll(Request $req){
        $enroll=new EnrollC;
        $enroll->user_id=$req->input('user_id');
        $enroll->course_id=$req->input('course_id');
        $enroll->save();


        return response()->json(['message' => 'user got enrolldd!'], 200);
    }
}