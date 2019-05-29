<?php

session_start();

require __DIR__ . "/../vendor/autoload.php";

$client = new MongoDB\Client(
    'mongodb+srv://admin:elibrary1234@cluster0-sndra.mongodb.net/test?retryWrites=true'
);

$db = $client->Elibrary;

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => $db,
    ]
]);

$container = $app->getContainer();

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['validator'] = function ($container) {
    return new App\Validation\Validator;
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

$container['AuthController'] = function ($container) {
    return new \App\Controllers\AuthController($container);
};

$container['auth'] = function ($container) {
    return new \App\Helpers\AuthHelper;
};

$container['view'] = function ($container) {

    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);

    $view->addExtension(new Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri(),

    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user()
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

\App\Models\User::init($db->Users);
\App\Models\Text::init($db->Texts);

$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));
$app->add(new \App\Middlewares\OldInputMiddleware($container));

require __DIR__ . '/../app/routes.php';
