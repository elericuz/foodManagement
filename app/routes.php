<?php

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $view = \Slim\Views\Twig::fromRequest($request);
        return $view->render($response, 'index.phtml');
    })->setName('home');

//    $app->get('/dashboard', function (Request $request, Response $response) {
//        $view = \Slim\Views\Twig::fromRequest($request);
//        return $view->render($response, 'dashboard.phtml');
//    });

    $app->get('/dashboard', \Controller\MainController::class . ':home');

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
