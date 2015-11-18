<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\NotFoundException;
use Doctrine\Common\Persistence\Mapping\MappingException;

$app = require(__DIR__.'/../app/bootstrap.php');

require(APPPATH.'routes.php');

$app->run();
