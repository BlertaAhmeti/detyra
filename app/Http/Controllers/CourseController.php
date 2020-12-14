<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Course;
class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //shto kurs
    public function addCourse(Request $req){
        try{
        $course=new Course;
        $course->name=$req->input('name');
        $course->description=$req->input('description');
        $course->instructor_id=$req->input('instructor_id');
        $course->save();


         //return successful response
         return response()->json(['course' => $course, 'message' => 'CREATED'], 201);

     } catch (\Exception $e) {
         //return error message
         return response()->json(['message' => 'course Registration Failed!'], 409);
     }

    }

    //get all courses
    function list(){
        // a po  eshef qetu skemi bo naj logjike
        return Course::all();
    }


    //merri kejt postet e nje kursi te caktuar
    function currentPost(){
        return Course::find(1)->getPosts;
    }


    function delete($id){
       
     $course=Course::find($id);
   
     $result=$course->delete();

     if($result)
      {
        return ["Result"=>"Course has been deleted"];
      }
      else
        {
          return ["Result"=>"Course has notbeen deletes"];
        }
    }

    
  
}
