<?php

namespace App\Model;
use Cartalyst\Sentinel\Sentinel;

/**
 * @property Sentinel  auth
*/

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

    public function delete()
    {   
        $this->auth->giftlist->commentgift->delete();
        
        return parent::delete();
    }
}