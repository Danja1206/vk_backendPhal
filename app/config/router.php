<?php

use Phalcon\Mvc\Router;
use App\Controllers\AuthController;


$router = $di->getRouter();

$router->addPost('/register', [
    'controller' => 'register',
    'action'     => 'register',
]);

$router->addPost('/authorize', [
    'controller' => 'auth',
    'action'     => 'authentication',
]);

$router->addGet('/feed', [
    'controller' => 'feed',
    'action'     => 'feed',
]);

// Define your routes here

$di->set('router', function () use ($router) {
    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
    $router->handle(str_replace('index.php/', '', $_SERVER['REQUEST_URI']));
    return $router;
});

$router->handle($_SERVER['REQUEST_URI']);
