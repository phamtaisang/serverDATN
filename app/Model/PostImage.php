<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $fillable = [
        'post_id', 'image'
    ];
    protected $visible = ['path'];
    public function path() {
        $this->path = 'aaa';
        return $this;
    }
}
