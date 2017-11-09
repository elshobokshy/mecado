<?php

namespace App\Model;
use Cartalyst\Sentinel\Sentinel;

/**
 * @property Sentinel  auth
 */
class Commentgift extends Model
{
    protected $table = 'commentgift';

    public function gift()
    {
        return $this->belongsTo('\App\Model\Gift');
    }

    public function delete()
    {   
        //$this->auth->giftlist->commentgift->delete();
        
        return parent::delete();
    }
}