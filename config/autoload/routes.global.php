<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
        'factories' => [
        ],
    ],

    'routes' => [
        [
            'name' => 'api-rest',
            'path' => '/api/rest[/{resourceName}[/{id}]]',
            'middleware' => 'api-rest',
            'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        ],
        [
            'name' => 'interrupt.cron',
            'path' => '/interrupt/cron',
            'middleware' => \rollun\viewer\Middleware\CronExceptionMiddleware::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'home-page',
            'path' => '/[{name}]',
            'middleware' => 'home-service',
            'allowed_methods' => ['GET'],
        ],
    ],
];
