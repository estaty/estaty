<?php

use Silex\Provider\MonologServiceProvider;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app['twig.options'] = ['debug' => false, 'cache' => false];

$app->register(new MonologServiceProvider(), [
    'monolog.logfile' => __DIR__.'/../var/log/silex_test.log',
    'monolog.name' => 'estaty'
]);
