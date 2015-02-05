<?php

use Estaty\Application;

// Use Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();

// Include the environment-specific config
require __DIR__.'/../config/env.php';

// Include the configuration
require __DIR__.'/../config/default.php';

// Include the web profiler after all is set up
require __DIR__.'/../config/profiler.php';

return $app;
