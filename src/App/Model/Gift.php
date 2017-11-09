<?php

namespace App\Model;

class Gift extends Model
{
    protected $table = 'gift';

    protected $fillable = [
        'giftlist_id',
        'name',
        'url',
        'description',
        'price',
        'picture',
        'booked'
    ];

    public function commentgift()
    {
        return $this->hasMany('\App\Model\Commentgift');
    }

    public function giftlist()
    {
        return $this->belongsTo('\App\Model\Giftlist');
    }
}
