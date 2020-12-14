<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{     
    protected $fillable = [
        'comment', 'post_id', 'std_id',
    ];

    

}
   
?>