<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $keyType = 'string';
    protected $fillable = [
        'user_id', 'description', 'title', 'status', 'type'
    ];

    public function postImage()
    {
        return $this->hasMany('App\Model\PostImage');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function position()
    {
        return $this->hasMany('App\Model\Position');
    }

    public function like()
    {
        return $this->hasMany('App\Model\Like');
    }

    public function comment(){
        return $this->hasMany('App\Model\Comment');

    }

    public function trip() {
        return $this->hasOne('App\Model\Trip');
    }

}
