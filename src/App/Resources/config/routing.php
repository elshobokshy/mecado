<?php

$app->get('/', 'app.controller:home')->setName('home');
$app->get('/test', 'test.controller:test')->setName('test');
$app->get('/myaccount', 'app.controller:myaccount')->setName('myaccount');

$app->get('/list/{token}/newgift','app.controller:about')->setName('About');

$app->post('/myaccount', 'app.controller:editProfile');

$app->get('/mylists', 'list.controller:mylists')->setName('mylists');
$app->get('/addlist', 'list.controller:addlist')->setName('addlist');
$app->post('/addlist', 'list.controller:addlist');
$app->get('/list/{token}','list.controller:fetch')->setName('list/{token}');
$app->get('/about','app.controller:about')->setName('About');
