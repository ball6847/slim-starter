<?php

return [
    'doctrine' => function ($container) {
        return Jgut\Slim\Middleware\DoctrineMiddleware::createEntityManager($container);
    },
    'inflector' => function ($container) {
        return ICanBoogie\Inflector::get('en');
    },
    'notFoundHandler' => function ($container) {
        return function ($request, $response) use ($container) {
            return $container['response']
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Resource not found.']));
        };
    },
    'errorHandler' => function ($container) {
        return function ($request, $response, $exception) use ($container) {
            return $container['response']
                ->withStatus(500)
                ->withHeader('Content-Type', 'text/html')
                ->write(json_encode(['error' => 'Something went wrong!']));
        };
    },
    'badRequestHandler' => function ($container) {
        return function($request, $response, $instruction = "Bad request.") use ($container) {
            return $container['response']
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => $instruction]));
        };
    },
    'jsonHandler' => function ($container) {
        return function ($request, $response, $data) use ($container) {
            return $container['response']
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($data));
        };
    }
];
