<?php

use \Illuminate\Database\Capsule\Manager as DB;

DB::table('activations')->insert(
    [
        'id' => 1,
        'user_id' => 1,
        'code' => 'G0rGwnlaQZMzKuJFcVtM111SZrjTIEQQ',
        'completed' => 1,
        'completed_at' => '2017-11-06 17:35:37'
    ]
);

DB::table('role_users')->insert(
    [
        'user_id' => 1,
        'role_id' => 2
    ]
);

DB::table('user')->insert(
    [
        'id' => 1,
        'username' => 'test',
        'email' => 'test@test.com',
        'password' => '$2y$10$.0.MMydi9fowTm/luU4BSumoJwWdFHHe0RKXTeUfel.7meMCaZlr2',
        'permissions' => '{"user.delete":0}',
        'last_login' => '2017-11-06 17:31:24'
    ]
);

DB::table('giftlist')->insert(
    [
        'id' => 1,
        'name' => 'test',
        'description' => 'test.description',
        'token' => 'i9fowTm/luU4BSumoJwWdFHHe0RKXTeUfel.7meMCaZlr2',
        'date' => '2018-11-06',
        'recipient' => 'the recipient',
        'user_id' => 1
    ]
);

DB::table('gift')->insert(
    [
        'id' => 1,
        'giftlist_id' => 1,
        'name' => 'a gift',
        'booked' => 0
    ]
);

DB::table('commentlist')->insert(
    [
        'id' => 1,
        'author' => 'the author',
        'content' => 'the content',
        'giftlist_id' => 1
    ]
);


DB::table('commentgift')->insert(
    [
        'id' => 1,
        'author' => 'the author',
        'content' => 'the content',
        'gift_id' => 1
    ]
);