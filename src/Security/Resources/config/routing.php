<?php

$app->group('', function () {
    $this->post('/login', 'auth.controller:login')->setName('login');
    $this->get('/login', 'app.controller:home')->setName('home');
    $this->map(['GET', 'POST'], '/register', 'auth.controller:register')->setName('register');
})->add($container['guest.middleware']);

$app->get('/logout', 'auth.controller:logout')
    ->add($container['auth.middleware']())
    ->setName('logout');
