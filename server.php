<?php

/**
 * PHP Built-in Server Controller
 * You can run server using the following command
 *
 * php -S 0.0.0.0:8000 -t public server.php
 *
 **/

define('__DOCUMENT_ROOT__', __DIR__.'/public');

// ---------------------------------------------------

// absolute path of requested file
$filename = __DOCUMENT_ROOT__.$_SERVER['REQUEST_URI'];

// serve file as it-is
if (php_sapi_name() === 'cli-server' && is_file(__DOCUMENT_ROOT__.$_SERVER['REQUEST_URI'])) {
    return false;
}

// run our application
require __DOCUMENT_ROOT__.'/index.php';
