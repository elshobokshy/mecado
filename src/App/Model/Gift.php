<?php

namespace App\Model;


class Gift extends Model
{
    protected $table = 'gift';

    public function commentgift()
    {
        return $this->hasMany('Commentgift');
    }

    public function giftlist()
    {
        return $this->belongsTo('Giftlist');
    }
}