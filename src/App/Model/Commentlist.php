<?php

namespace App\Model;
use Cartalyst\Sentinel\Sentinel;

/**
 * @property Sentinel  auth
*/
class Commentlist extends Model
{
    protected $table = 'commentlist';

    public function giftlist()
    {
        return $this->belongsTo('\App\Model\Giftlist');
    }

    public function delete()
    {   
        //$this->auth->giftlist->commentlist->delete();
        
        return parent::delete();
    }
}