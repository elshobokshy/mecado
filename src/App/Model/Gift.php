<?php

namespace App\Model;

class Gift extends Model
{
    protected $table = 'gift';

    public function commentgift()
    {
        return $this->hasMany('\App\ModeL\Commentgift');
    }

    public function giftlist()
    {
        return $this->belongsTo('\App\Model\Giftlist');
    }
}