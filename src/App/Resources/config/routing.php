<?php

$app->get('/', 'app.controller:home')->setName('home');
$app->get('/test', 'test.controller:test')->setName('test');

$app->get('/about', 'app.controller:about')->setName('about');

$app->get('/myaccount', 'app.controller:myaccount')->setName('myaccount')->add($container['auth.middleware']());
$app->post('/myaccount', 'app.controller:editProfile')->add($container['auth.middleware']());


$app->get('/mylists', 'list.controller:mylists')
    ->setName('mylists')
    ->add($container['auth.middleware']());

$app->map(['GET', 'POST'], '/addlist', 'list.controller:addlist')
    ->setName('addlist')
    ->add($container['auth.middleware']());

$app->get('/list/{token}', 'list.controller:fetch')->setName('list');

$app->map(['GET', 'POST'], '/list/{token}/newgift', 'gift.controller:newgift')
    ->setName('newgift')
    ->add($container['auth.middleware']());


$app->post('/book/{token}/{id}', 'gift.controller:book')->setName('book');
$app->post('/participate/{token}/{id}', 'gift.controller:participate')->setName('participate');




$app->post('/list/{token}/addcomment', 'list.controller:commentList')->setName('commentList');

$app->get('/editmylist/{token}', 'list.controller:editList')->setName('editmylist')->add($container['auth.middleware']());
$app->post('/editmylist/{token}', 'list.controller:editList')->add($container['auth.middleware']());

$app->post('/list/{token}/{id}/delete','gift.controller:delete')->setName('deletegift');
$app->post('/mylists/{id}/delete','list.controller:delete')->setName('deletelist');