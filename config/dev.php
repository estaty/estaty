<?php

use Silex\Provider;
use Monolog\Logger;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// enable the debug mode
$app['debug'] = true;

$app['monolog.level'] = $app['debug'] ? Logger::DEBUG : Logger::INFO;

if ('cli' !== PHP_SAPI) {
    $app->register(new Provider\HttpFragmentServiceProvider());
}
