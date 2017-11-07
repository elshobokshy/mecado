<?php

$controllers = [
    'admin.controller' => 'Admin\Controller\AdminController',
    'app.controller'   => 'App\Controller\AppController',
    'test.controller'   => 'App\Controller\TestController',
    'auth.controller'  => 'Security\Controller\AuthController',
    'list.controller'  => 'App\Controller\ListController'
];

foreach ($controllers as $key => $class) {
    $container[$key] = function ($container) use ($class) {
        return new $class($container);
    };
}
