<?php

namespace App\Model;

use Cartalyst\Sentinel\Sentinel;

class Giftlist extends Model
{
    protected $table = 'giftlist';

    protected $fillable = [
        'name',
        'description',
        'token',
        'date',
        'recipient',
        'user_id',
    ];

    public function commentlist()
    {
        return $this->hasMany('\App\Model\Commentlist');
    }

    public function gift()
    {
        return $this->hasMany('\App\Model\Gift');
    }

    public function commentgift()
    {
        return $this->hasManyThrough('\App\Model\Commentgift', '\App\Model\Gift', 'giftlist_id', 'gift_id', 'id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('\Security\Model\User');
    }
}