<?php

namespace App\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mpociot\Firebase\SyncsWithFirebase;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SyncsWithFirebase;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'password', 'nick_name', 'phone', 'gender', 'address', 'email','description'
    ];

//    protected $visible = ['id', 'name', 'avatar', 'address'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function trip() {
        return $this->hasMany('App\Model\Trip');
    }

    public function device() {
        return $this->hasMany('App\Model\UserDevice');
    }
}
