<?php

$app->get('/', 'app.controller:home')->setName('home');
$app->get('/test', 'test.controller:test')->setName('test');
$app->get('/myaccount', 'app.controller:myaccount')->setName('myaccount')->add($container['auth.middleware']());

$app->get('/list/{token}/newgift','gift.controller:newgift')->setName('newgift')->add($container['auth.middleware']());

$app->post('/myaccount', 'app.controller:editProfile')->add($container['auth.middleware']());

$app->get('/mylists', 'list.controller:mylists')->setName('mylists')->add($container['auth.middleware']());
$app->get('/editmylist/{token}', 'list.controller:editList')->setName('editmylist')->add($container['auth.middleware']());
$app->post('/editmylist/{token}', 'list.controller:editList')->add($container['auth.middleware']());

$app->get('/addlist', 'list.controller:addlist')->setName('addlist')->add($container['auth.middleware']());
$app->post('/addlist', 'list.controller:addlist')->add($container['auth.middleware']());

$app->get('/list/{token}','list.controller:fetch')->setName('list')->add($container['auth.middleware']());
$app->get('/about','app.controller:about')->setName('about');
