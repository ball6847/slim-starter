<?php

require_once __DIR__."/constant.php";
require_once APPPATH."vendor/autoload.php";

// ---------------------------------------------------

$config = require(APPPATH.'config.php');

if (is_file(APPPATH.'config.local.php')) {
    $config = array_merge_recursive($config, include(APPPATH.'config.local.php'));
}

// ---------------------------------------------------

// bootup doctrine
require(APPPATH.'doctrine/bootstrap.php');

// ---------------------------------------------------

$app = new Slim\Slim($config);

return $app;

