<?php

namespace App\Model;

class Giftlist extends Model
{
    protected $table = 'giftlist';

    public function commentlist()
    {
        return $this->hasMany('App/Model/Commentlist');
    }

    public function gift()
    {
        return $this->hasMany('App/Model/Gift');
    }

    public function user()
    {
        return $this->belongsTo('Security/Model/User');
    }
}