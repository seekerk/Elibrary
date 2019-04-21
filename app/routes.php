<?php

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');

$app->get('/key-search', 'SearchController:findbyKeyWords')->setName('key_search');

$app->get('/show', 'TextController:findbyID');
