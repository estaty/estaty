<?php

use Silex\Provider;
use Monolog\Logger;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// enable the debug mode
$app['debug'] = false;

$app['monolog.level'] = $app['debug'] ? Logger::DEBUG : Logger::INFO;

if ('cli' !== PHP_SAPI AND true === $app['debug']) {
    $app->register(new Provider\HttpFragmentServiceProvider());
    $app->register(new Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
    ));
}
