<?php

// Initialize the application
$app = require __DIR__.'/../src/app.php';

// Include the controllers
require __DIR__.'/../src/controllers.php';

// Include the environment-specific config
require __DIR__.'/../config/env.php';

// Run the app
$app->run();
