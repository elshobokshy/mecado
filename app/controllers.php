<?php

$controllers = [
    'admin.controller' => 'Admin\Controller\AdminController',
    'app.controller' => 'App\Controller\AppController',
    'test.controller' => 'App\Controller\TestController',
    'gift.controller' => 'App\Controller\GiftController',
    'auth.controller' => 'Security\Controller\AuthController'
];

foreach ($controllers as $key => $class) {
    $container[$key] = function ($container) use ($class) {
        return new $class($container);
    };
}
