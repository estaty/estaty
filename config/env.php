<?php

use Silex\Provider\MonologServiceProvider;

// Load environment and relevant configuration
$app['env'] = getenv('ESTATY_ENV') ?: 'prod';

$app->register(new MonologServiceProvider(), [
    'monolog.logfile' => __DIR__.'/../var/log/silex_'.$app['env'].'.log',
    'monolog.name' => 'estaty',
]);

require __DIR__.'/../config/'.$app['env'].'.php';

require 'errors.php';
