<?php

$app = require(dirname(__DIR__).'/bootstrap.php');

$app->get('/', function(){
    echo "Hello World";
});

$app->run();
