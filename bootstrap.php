<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ---------------------------------------------------

define('APPPATH', __DIR__.'/');
define('DOCUMENT_ROOT', __DIR__.'/public/');

// ---------------------------------------------------

require APPPATH."vendor/autoload.php";

// read config file
$config = require APPPATH.'config.php';

if (is_file(APPPATH.'config.local.php')) {
    $config = array_merge_recursive($config, include(APPPATH.'config.local.php'));
}

// start application
$app = new Slim\Slim($config);

return $app;

