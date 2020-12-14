<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use App\Models\Comment;

use App\Models\EnrollC;

 //import auth facades
 use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    //create nnew post
    public function createPost(Request $request){
        
        $post=Post::create($request->all());
        return response()->json($post);
    }
  
 

    //update a post
    public function updatePost(Request $request, $id){
        $post = Post::find($id);
        $post->title=$request->title;
        $post->body=$request->body;
        $post->views=$request->views;

        return response()->json($post);
    }


        //view post
        public function viewPostt($id){
            $post = Post::find($id);
            
    
            return response()->json($post);
        }
    //delete post
    public function deletePost($id){
        $post = Post::find($id);
        $post->delete();

        return response()->json('removed succesfuly');
    }

    //get all post of enrolled course
    public function index1(){


       
 
        $checkIfUserHasEnrolled = EnrollC::where('user_id', auth()->user()->id)->first();
        
        if($checkIfUserHasEnrolled){
            $getPostsOfHisCourse = Post::where('course_id', $checkIfUserHasEnrolled->course_id)->get();
            return response()->json($getPostsOfHisCourse);
        }
        return response()->json("you are not enrolled in a course ");

      
    }


    public function comment(Request $req){
        $comment=new Comment;
        $comment->comment=$req->input('comment');
        $comment->post_id=$req->input('post_id');
        $comment->std_id=$req->input('std_id');
        $comment->save();
   
        return response()->json('comment added succesfuly');
    }


//delete a coment 
    function deleteComment($id){
       
        $comment=Comment::find($id);
      
        $result=$comment->delete();
   
        if($result)
         {
           return ["Result"=>"Comment has been deleted"];
         }
         else
           {
             return ["Result"=>"Comment has notbeen deletes"];
           }
       }

    
    //a user can delete his own reply 
       function deleteYourComment1($id){
       
        $comment=Comment::find($id);
        
        $ifHasItsOwnComment = Comment::where('std_id', auth()->user()->id)->first();
        if(!$ifHasItsOwnComment){
            return response()->json([
                "error" => " you cannot delete comments that aren't yours",
            ]);
        }else {
            Comment::where('id', $comment->id)->delete();
            return response()->json(["success" => "Comment Has been deleted"]);
        }

       }
}
