<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// -----------------------------------------------------

$app = require(__DIR__.'/../application.php');

$app->get('/{model}', function(Request $request, Response $response, $params = []) {
    $products = $this->doctrine->getRepository('Product');
    $products = $products->findAll();

    var_dump($products);
});

$app->run();
