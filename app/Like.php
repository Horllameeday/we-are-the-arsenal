<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function post(){
        return $this->belongsTo('App\Post');
    }
}
