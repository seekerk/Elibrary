<?php

session_start();

require __DIR__ . "/../vendor/autoload.php";

$client = new MongoDB\Client(
    'mongodb+srv://admin:elibrary1234@cluster0-sndra.mongodb.net/test?retryWrites=true');
  
$db = $client->Elibrary;

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => $db,
    ]
]);

$container = $app->getContainer();

$container['view'] = function ($container) {

    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);

	$view->addExtension(new Slim\Views\TwigExtension(
		$container->router, 
        $container->request->getUri(),
        
    ));
    
    return $view;
};

$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};

$container['SearchController'] = function ($container) {
    return new \App\Controllers\SearchController($container);
};

$container['TextController'] = function ($container) {
    return new \App\Controllers\TextController($container);
};

$container["Users"] = function ($container) {
    $db = $container['settings']['db'];
    return new \App\Models\User($db->Users);
};

$container["Texts"] = function ($container) {
    $db = $container['settings']['db'];
    return new \App\Models\Text($db->Texts);
};

require __DIR__ . '/../app/routes.php';