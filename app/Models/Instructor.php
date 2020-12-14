<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

//jwt auth
use Tymon\JWTAuth\Contracts\JWTSubject;

 //import auth facades
 use Illuminate\Support\Facades\Auth;


class Instructor extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{  
    
    
    protected $fillable = [
        'name', 'email', 'password'
    ];




    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
    ];


    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthIdentifierName()
    {
        return [];
    }
    public function getAuthIdentifier()
    {
        return [];
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function getRememberToken()
    {
        return [];
    }

    public function setRememberToken($value)
    {
        return [];
    }

    public function getRememberTokenName()
    {
        return [];
    }

    public function can($abilities, $arguments = [])
    {
        return [];
    }

}

?>