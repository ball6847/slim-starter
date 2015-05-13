<?php

require_once __DIR__."/constant.php";
require_once APPPATH."vendor/autoload.php";

// ---------------------------------------------------

$config = require(APPPATH.'config.php');

if (is_file(APPPATH.'config.local.php')) {
    $config = array_merge_recursive($config, include(APPPATH.'config.local.php'));
}

// ---------------------------------------------------

// we need $doctrine DoctrineMiddleware object, required for later setup in cli-config.php
$doctrine = new Jgut\Slim\Middleware\DoctrineMiddleware();

$app = new Slim\Slim($config);
$app->add($doctrine);

return $app;

