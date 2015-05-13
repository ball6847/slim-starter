<?php

$app = require(__DIR__.'/../application.php');

$app->get('/', function() use ($app) {
    $products = $app->entityManager->getRepository('Product');
    
    $products = $products->findAll();

    var_dump($products);
});

$app->run();
