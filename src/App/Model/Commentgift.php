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
}
