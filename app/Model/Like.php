<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'post_id', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

}
