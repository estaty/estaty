<?php

// Use Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Initialize the application
$app = require __DIR__.'/../src/app.php';

// Load environment and relevant configuration
$environment = getenv('ESTATY_ENV') ?: 'prod';
require __DIR__.'/../config/'.$environment.'.php';
unset($environment);

// Include the controllers
require __DIR__.'/../src/controllers.php';

// Run the app
$app->run();
