<?php

namespace Security\Model;

use Cartalyst\Sentinel\Users\EloquentUser;
use Cartalyst\Sentinel\Sentinel;

/**
 * @property Sentinel  auth
*/
class User extends EloquentUser
{
    protected $table = 'user';

    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    protected $loginNames = ['email'];

    public function giftlist()
    {
        return $this->hasMany('\App\Model\Giftlist');
    }
}
