<?php

use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/key-search', 'SearchController:findbyKeyWords')->setName('key_search');

$app->get('/show', 'TextController:findbyID');

$app->group('', function() use ($app){
    $app->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
})->add(new AuthMiddleware($container));

$app->group('', function() use ($app){
    $app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $app->post('/auth/signin', 'AuthController:postSignIn');
    $app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $app->post('/auth/signup', 'AuthController:postSignUp');
})->add(new GuestMiddleware($container));