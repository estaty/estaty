<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
$app = require_once __DIR__.'/../src/app.php';

// Include the environment-specific config
require __DIR__.'/../config/env.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $app['orm.em'];

return ConsoleRunner::createHelperSet($entityManager);
