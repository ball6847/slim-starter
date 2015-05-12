<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__.'/doctrine/bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);
