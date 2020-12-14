<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{     
    protected $fillable = [
        'title', 'body', 'instructor_id', 'course_id',
    ];



    public function getComments()
    {
      return $this->hasMany('App\Models\Comment');
    }
}
   
?>