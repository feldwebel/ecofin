<?php

declare(strict_types=1);

use App\Router;

include_once '../vendor/autoload.php';

    $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
    $router = new Router();
    $response = $router->route($request);
    $response->send();