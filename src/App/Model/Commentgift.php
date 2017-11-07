<?php

namespace App\Model;


class Commentgift extends Model
{
    protected $table = 'commentgift';

    public function gift()
    {
        return $this->belongsTo('\App\Model\Gift');
    }
}