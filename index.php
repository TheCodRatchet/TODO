<?php

use App\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once 'vendor/autoload.php';

session_start();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'ActionsController@index');

    $r->addRoute('GET', '/actions', 'ActionsController@index');
    $r->addRoute('GET', '/actions/create', 'ActionsController@create');
    $r->addRoute('POST', '/actions', 'ActionsController@store');
    $r->addRoute('POST', '/actions/{id}', 'ActionsController@delete');
    $r->addRoute('GET', '/actions/{id}', 'ActionsController@show');

    $r->addRoute('GET', '/users', 'UsersController@index');

    $r->addRoute('GET', '/register', 'AuthController@showRegisterForm');
    $r->addRoute('POST', '/register', 'AuthController@register');

    $r->addRoute('GET', '/login', 'AuthController@showLoginForm');
    $r->addRoute('POST', '/login', 'AuthController@login');

    $r->addRoute('POST', '/logout', 'AuthController@logout');
});

function base_path(): string
{
    return __DIR__;
}

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

$loader = new FilesystemLoader(base_path() . '/app/Views');
$templateEngine = new Environment($loader, []);
$templateEngine->addGlobal('session', $_SESSION);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = explode('@', $handler);
        $controller = "App\Controllers\\" . $controller;
        $controller = new $controller();
        $response = $controller->$method($vars);

        if ($response instanceof View) {
            echo $templateEngine->render($response->getTemplate(), $response->getArguments());
        }
        break;
}