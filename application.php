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

return new Slim\App($container);
