<?php

use Estaty\Application;

// Use Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();

// Include the configuration
require __DIR__.'/../config/default.php';

return $app;
