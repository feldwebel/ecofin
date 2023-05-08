<?php

declare(strict_types=1);

namespace App;

use App\Actions\ApiPushAction;
use App\Actions\AverageDayAction;
use App\Actions\AverageSensorAction;
use App\Actions\SensorReadAction;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function FastRoute\simpleDispatcher;

class Router
{
    public function route(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $r) {
            $r->addRoute('POST', '/api/push', new ApiPushAction());
            $r->addRoute('GET', '/sensor/read/{ip}', new SensorReadAction());
            $r->addRoute('GET', '/average/sensor/{ip}', new AverageSensorAction());
            $r->addRoute('GET', '/average/day/{day:\d+}', new AverageDayAction());

        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getRequestUri());
        $status = $routeInfo[0];
        $handler = $routeInfo[1] ?? null;
        $query = $routeInfo[2] ?? null;
        try {
            switch ($status) {
                case Dispatcher::NOT_FOUND:
                    $response = (new JsonResponse())->setStatusCode(Response::HTTP_NOT_FOUND);
                    break;
                case Dispatcher::METHOD_NOT_ALLOWED:
                    $response = (new JsonResponse())->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
                    break;
                case Dispatcher::FOUND:
                    $response = $handler($query);
                    break;
            }
        } catch (\Throwable $ex) {
            $response = (new JsonResponse())
                ->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->setData(['error' => $ex->getMessage()])
            ;
        }
        return $response;
    }
}
