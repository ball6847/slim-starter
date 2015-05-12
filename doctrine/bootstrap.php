<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require_once __DIR__."/../constant.php";
require_once APPPATH."vendor/autoload.php";

$entityManager = EntityManager::create(array(
        'driver' => 'pdo_sqlite',
        'path' => APPPATH.'db.sqlite'
    ), 
    Setup::createAnnotationMetadataConfiguration(array(APPPATH."/models"), true)
);
