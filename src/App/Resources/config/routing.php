<?php

$app->get('/', 'app.controller:home')->setName('home');
$app->get('/test', 'test.controller:test')->setName('test');
$app->get('/myaccount', 'app.controller:myaccount')->setName('myaccount');
$app->get('/mylists', 'list.controller:mylists')->setName('mylists');
$app->get('/addlist', 'list.controller:addlist')->setName('addlist');

