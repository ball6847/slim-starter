<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// load Slim application, we need $doctrine DoctrineMiddleware
$app = require(__DIR__."/application.php");

// setup middleware
// $doctrine->setup();

// create entityManager
// $em = $doctrine->createEntityManager();

return ConsoleRunner::createHelperSet($app->doctrine);
