<?php

$app->get('/', 'app.controller:home')->setName('home');
$app->get('/test', 'test.controller:test')->setName('test');
$app->get('/myaccount', 'app.controller:myaccount')->setName('myaccount');
