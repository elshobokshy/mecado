<?php

$app->get('/', 'app.controller:home')->setName('home');


$app->get('/myaccount', 'app.controller:myaccount')->setName('myaccount');
