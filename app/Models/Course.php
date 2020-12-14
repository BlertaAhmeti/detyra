<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Course extends Model
{  
    public $table="courses";
    protected $fillable = [
        'name', 'description', 'instructor_id',
    ];


    public function getPosts()
    {
      return $this->hasMany('App\Models\Post');
    }

}

?>