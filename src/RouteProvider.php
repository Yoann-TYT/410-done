<?php

namespace App;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteProvider
{
    public static function getRoutes(): RouteCollection
    {
        $routes = new RouteCollection();
        $routes->add('home', new Route('/', [
            '_controller' => function (): Response {
                return new Response(
                    file_get_contents(ROOT_DIR . '/templates/index.html'),
                    Response::HTTP_OK,
                    ['Content-Type' => 'text/html']
                );
            }]
        ));

        $routes->add('teams', new Route('/teams', [
            '_controller' => function (): Response {
                return new Response(
                    json_encode((new DataProvider())->getTeamsWithUsers()),
                    Response::HTTP_OK,
                    ['Content-Type' => 'application/json']
                );
            }]
        ));

        return $routes;
    }
}
