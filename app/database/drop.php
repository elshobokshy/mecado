<?php

use Illuminate\Database\Capsule\Manager;

$tables = [
    'commentgift',
    'commentlist',
    'gift',
    'giftlist',

    'activations',
    'persistences',
    'reminders',
    'role_users',
    'throttle',
    'roles',
    'user'
];

Manager::schema()->disableForeignKeyConstraints();
foreach ($tables as $table) {
    Manager::schema()->dropIfExists($table);
}
