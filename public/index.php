<?php

$app = require(__DIR__.'/../bootstrap.php');

$app->get('/', function() use ($entityManager) {
    $products = $entityManager->getRepository('Product')->findAll();

    var_dump($products);
});

$app->run();
