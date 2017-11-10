<?php

use \Illuminate\Database\Capsule\Manager as DB;
use \App\Model\Gift;
use \App\Model\Giftlist;
use \App\Model\Commentgift;
use \App\Model\Commentlist;
use Security\Model\User;

DB::table('activations')->insert([
    [
        'id' => 1,
        'user_id' => 1,
        'code' => 'G0rGwnlaQZMzKuJFcVtM111SZrjTIEQQ',
        'completed' => 1,
        'completed_at' => '2017-11-06 17:35:37'
    ]
]);

DB::table('role_users')->insert([
    [
        'user_id' => 1,
        'role_id' => 2
    ]
]);

User::insert(
    [
        'id' => 1,
        'email' => 'John.Walter@gmail.com',
        'password' => '$2y$10$.0.MMydi9fowTm/luU4BSumoJwWdFHHe0RKXTeUfel.7meMCaZlr2',
        'first_name' => 'John',
        'last_name' => 'Walter',
        'permissions' => '{"user.delete":0}',
        'last_login' => '2017-11-06 17:31:24'
    ]
);

Giftlist::insert([
    [
        'id' => 1,
        'name' => 'Catherine\'s birthday',
        'description' => 'This a list of gifts that Catherine would like have for her birthday',
        'token' => 'i9fowTmluU4BSumoJwWdFHHe0RKXTeUfel7meMCaZlr2',
        'date' => '2018-11-06',
        'recipient' => 'Catherine Walter',
        'user_id' => 1
    ]
]);

Gift::insert([
    [
        'id' => 1,
        'giftlist_id' => 1,
        'name' => 'The new smartphone',
        'url' => 'https://www.apple.com/iphone-x/',
        'description' => 'My wife really want this phone and I want to give her the best',
        'price' => 1500,
        'booked' => 0,
        'kitty' => 1,
        'picture'=>'1871958921899.png',
        'contributions' => 0.0
    ], [
        'id' => 2,
        'giftlist_id' => 1,
        'name' => 'An ironner',
        'url' => '',
        'description' => 'Catherine has broken his ironner last week, so I\'d like to give her a new one',
        'price' => 350,
        'booked' => 0,
        'kitty' => 0,
        'picture'=>null,
        'contributions' => 350
    ], [
        'id' => 3,
        'giftlist_id' => 1,
        'name' => 'A puppy',
        'url' => '',
        'description' => 'Because I like her very much and we can\'t have children',
        'price' => 900,
        'booked' => 1,
        'kitty' => 0,
        'picture' => '19446148948551.jpg',
        'contributions' => 900

    ]
]);

Commentlist::insert([
    [
        'id' => 1,
        'author' => 'John Walter',
        'content' => 'Of course you are note forced to reffer on this list :-)',
        'giftlist_id' => 1
    ]
]);

Commentgift::insert([
    [
        'id' => 1,
        'author' => 'John Walter',
        'content' => 'Happy birthday honey',
        'gift_id' => 3
    ]
]);
