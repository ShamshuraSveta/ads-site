<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
   protected $fillable = ['text', 'user_id', 'photo', 'published', 'title'];
   
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function comments() 
    {
        return $this->hasMany('App\Comment');
    }
}
