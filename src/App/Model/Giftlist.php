<?php

namespace App\Model;


class Giftlist extends Model
{
    protected $table = 'giftlist';

    public function commentlist()
    {
        return $this->hasMany('Commentlist');
    }

    public function gift()
    {
        return $this->hasMany('Gift');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}