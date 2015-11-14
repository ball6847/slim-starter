<?php

require_once __DIR__."/constant.php";
require_once APPPATH."vendor/autoload.php";

// ---------------------------------------------------

$config = require(APPPATH.'config.php');

if (is_file(APPPATH.'config.local.php')) {
    $config = array_merge_recursive($config, include(APPPATH.'config.local.php'));
}

// ---------------------------------------------------

$container = new Slim\Container($config);

$container['doctrine'] = function ($container) {
    return Jgut\Slim\Middleware\DoctrineMiddleware::createEntityManager($container);
};

$container['inflector'] = function ($container) {
    return ICanBoogie\Inflector::get('en');
};

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(['error' => 'Resource not found.']));
    };
};

$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        return $container['response']
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write(json_encode(['error' => 'Something went wrong!']));
    };
};

$container['badRequestHandler'] = function ($container) {
    return function($request, $response, $instruction = "Bad request.") use ($container) {
        return $container['response']
            ->withStatus(400)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(['error' => $instruction]));
    };
};

// $container['notAllowedHandler'] = function ($container) {
//     return function ($request, $response, $methods) use ($container) {
//         return $container['response']
//             ->withStatus(405)
//             ->withHeader('Allow', implode(', ', $methods))
//             ->withHeader('Content-Type', 'application/json')
//             ->write(json_encode(['error' => 'method not allowed!']));
//     };
// };

$container['jsonHandler'] = function ($container) {
    return function ($request, $response, $data) use ($container) {
        return $container['response']
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($data));
    };
};

$container['getEntity'] = function ($container) {
    return function ($model, $id = null) use ($container) {
        $inflector = $container['inflector'];
        $doctrine = $container['doctrine'];

        // determine model name to be used
        $entity = $inflector->camelize($inflector->singularize($model));

        // query data using doctrine
        if ( ! empty($id)) {
            return $doctrine->find($entity, $id);
        } else {
            return $doctrine->getRepository($entity);
        }
    };
};


return new Slim\App($container);
