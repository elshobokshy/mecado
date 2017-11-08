<?php

namespace App\Model;

class Giftlist extends Model
{
    protected $table = 'giftlist';

    protected $fillable = [
        'name',
        'description',
        'recipient',
        'date',
        'user_id',
        'token',
    ];

    public function commentlist()
    {
        return $this->hasMany('\App\Model\Commentlist');
    }

    public function gift()
    {
        return $this->hasMany('\App\Model\Gift');
    }

    public function commentgift(){
        return $this->hasManyThrough('\App\Model\Commentgift', '\App\Model\Gift','giftlist_id', 'gift_id', 'id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('\Security\Model\User');
    }
}