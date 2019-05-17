<?php

declare(strict_types=1);

namespace Gewaer\Providers;

use function Canvas\Core\appPath;
use Gewaer\Middleware\NotFoundMiddleware;
use Gewaer\Middleware\AuthenticationMiddleware;
use Gewaer\Middleware\TokenValidationMiddleware;
use Gewaer\Middleware\AclMiddleware;
use Canvas\Middleware\ThrottleMiddleware;
use Phalcon\Mvc\Micro;
use Canvas\Providers\RouterProvider as CanvasRouterProvider;

class RouterProvider extends CanvasRouterProvider
{
    /**
     * Attaches the routes to the application; lazy loaded.
     *
     * @param Micro $application
     */
    protected function attachRoutes(Micro $application)
    {
        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            include $route;
        }
    }

    /**
     * Returns the array for the middleware with the action to attach.
     *
     * @return array
     */
    protected function getMiddleware(): array
    {
        return [
            ThrottleMiddleware::class => 'before',
            TokenValidationMiddleware::class => 'before',
            NotFoundMiddleware::class => 'before',
            AuthenticationMiddleware::class => 'before',
            AclMiddleware::class => 'before',
        ];
    }

    /**
     * Returns the array for all the routes on this system.
     *
     * @return array
     */
    protected function getRoutes(): array
    {
        $path = appPath('api/routes');
        $canvsaPath = getenv('CANVAS_CORE_PATH');

        $routes = [
            'api' => $path . '/api.php',
            'canvas' =>  $canvsaPath. '/routes/api.php'
        ];

        return $routes;
    }
}
