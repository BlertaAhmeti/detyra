<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EnrollC extends Model
{     
     public $table="enrolled_std";
    protected $fillable = [
        'user_id', 'course_id',
    ];

}

?>