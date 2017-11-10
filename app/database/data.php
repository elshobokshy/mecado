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
        'email' => 'test@test.com',
        'password' => '$2y$10$.0.MMydi9fowTm/luU4BSumoJwWdFHHe0RKXTeUfel.7meMCaZlr2',
        'first_name' => 'firstestname',
        'last_name' => 'lastestname',
        'permissions' => '{"user.delete":0}',
        'last_login' => '2017-11-06 17:31:24'
    ]
);

Giftlist::insert([
    [
        'id' => 1,
        'name' => 'test',
        'description' => 'test.description',
        'token' => 'i9fowTmluU4BSumoJwWdFHHe0RKXTeUfel7meMCaZlr2',
        'date' => '2018-11-06',
        'recipient' => 'the recipient',
        'user_id' => 1
    ], [
        'id' => 2,
        'name' => 'test2',
        'description' => 'test.d2escription',
        'token' => '2i9fowTmluU4BSumzoJwWdFHHe0RKXTeUfel7meMCaZlr2',
        'date' => '2018-09-05',
        'recipient' => 'the recipient',
        'user_id' => 1
    ], [
        'id' => 3,
        'name' => 'test3',
        'description' => 'test3.description',
        'token' => 'zzzi9fowTmluU4BSumodzddFHHe0RKXTeUfel7meMCaZlr2',
        'date' => '2015-11-06',
        'recipient' => 'the second recipient',
        'user_id' => 1
    ]
]);

Gift::insert([
    [
        'id' => 1,
        'giftlist_id' => 1,
        'name' => 'a gift',
        'url' => 'https://www.google.fr/',
        'description' => 'ceci est un cadeau qui me plairait bien',
        'price' => 125,
        'booked' => 0,
        'kitty' => 0,
        'contributions' => 0
    ], [
        'id' => 2,
        'giftlist_id' => 1,
        'name' => 'a second gift',
        'url' => 'https://www.google.fr/',
        'description' => 'ceci est un AUTRE cadeau qui me plairait bien',
        'price' => 256,
        'booked' => 0,
        'kitty' => 0,
        'contributions' => 0
    ], [
        'id' => 3,
        'giftlist_id' => 1,
        'name' => 'a gift',
        'url' => null,
        'description' => null,
        'price' => 5.50,
        'booked' => 1,
        'kitty' => 0,
        'contributions' => 0
    ], [
        'id' => 4,
        'giftlist_id' => 2,
        'name' => 'a gift',
        'url' => null,
        'description' => null,
        'price' => 12,
        'booked' => 0,
        'kitty' => 0,
        'contributions' => 0
    ], [
        'id' => 5,
        'giftlist_id' => 2,
        'url' => null,
        'description' => null,
        'price' => 87,
        'name' => 'a gift',
        'booked' => 0,
        'kitty' => 0,
        'contributions' => 0
    ], [
        'id' => 6,
        'giftlist_id' => 2,
        'url' => null,
        'description' => null,
        'price' => 99.99,
        'name' => 'a gift',
        'booked' => 0,
        'kitty' => 0,
        'contributions' => 0
    ]
]);

Commentlist::insert([
    [
        'id' => 1,
        'author' => 'the author',
        'content' => 'the content',
        'giftlist_id' => 1
    ]
]);

Commentgift::insert([
    [
        'id' => 1,
        'author' => 'the author',
        'content' => 'the content',
        'gift_id' => 1
    ]
]);
