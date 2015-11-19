<?php
/**
 *  Doctrine Console Runner
 *
 *  See available commands by running: ./vendor/bin/doctrine
 */
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// load Slim application, we need $doctrine DoctrineMiddleware
$app = require(__DIR__."/app/bootstrap.php");

// create doctrine console application
ConsoleRunner::run(ConsoleRunner::createHelperSet($app->doctrine), [
    new Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand,
    new Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand,
    new Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand,
    new Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand,
    new Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand,
    new Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand,
]);
