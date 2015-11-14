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

// attach dependencies
$di = require(APPPATH.'di.php');

foreach ($di as $name => $callable) {
    $container[$name] = $callable;
}

return new Slim\App($container);
