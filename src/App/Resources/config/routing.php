<?php

$app->get('/', 'app.controller:home')->setName('home');


$app->get('/myaccount', 'app.controller:myaccount')->setName('myaccount');

$app->get('/about','app.controller:about')->setName('About');