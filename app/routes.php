<?php

$app->get('/', 'HomeController:index')->setName('home');

$app->post('/key-search', 'SearchController:findbyKeyWords')->setName('key_search');

$app->get('/show', 'TextController:findbyID');
