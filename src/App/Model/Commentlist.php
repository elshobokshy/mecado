<?php

namespace App\Model;


class Commentlist extends Model
{
    protected $table = 'commentlist';

    public function giftlist()
    {
        return $this->belongsTo('Giftlist');
    }
}