<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



$router->group(['middleware' => 'auth','prefix' => 'api'], function ($router) 
{   
    $router->get('coursePosts', 'PostsController@index1');
    $router->get('myProfile', 'AuthController@me');
    $router->post('logout', 'AuthController@logout');
    $router->get('list', 'CourseController@list'); 
    $router->post('enroll', 'UserController@enroll');
    $router->get('enrolled/viewPosts', 'UserController@enroll');
    $router->post('enrolled/comment', 'PostsController@comment');
    $router->delete('deleteYourComment/{id}', 'PostsController@deleteYourComment1');
   
});
//-------------
// API route group auth
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
   $router->post('register', 'AuthController@register');
   //extra pre-loginn (veq prove)
   $router->post('postLogin', 'AuthController@postLogin');
     // Matches "/api/login
    $router->post('login', 'AuthController@login');
  
 
 
     
});

//instructorController

$router->post('api/instructor/login', 'InstructorsController@login');
$router->group(['prefix' => 'api', 'middleware' => 'auth:instructor-api'], function () use ($router) {
    $router->post('instructor/register', 'InstructorsController@register');
    $router->get('instructor/mee', 'InstructorsController@mee');
    $router->post('add', 'CourseController@addCourse');
    $router->post('instructor/createPost', 'PostsController@createPost');
    $router->get('instructor/posts', 'InstructorsController@currentPost'); 
    $router->delete('instructor/deleteComment/{id}', 'PostsController@deleteComment');
    
});



//admin controller

$router->post('api/admin/login', 'AdminController@login');
$router->group(['prefix' => 'api/admin', 'middleware' => 'auth:admin-api'], function () use ($router) {
    $router->delete('delete/{id}', 'CourseController@delete');
    
});