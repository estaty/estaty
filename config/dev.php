<?php

// use Silex\Provider\MonologServiceProvider;
// use Silex\Provider\WebProfilerServiceProvider;

// include the default configuration
require __DIR__.'/default.php';

error_reporting(E_ALL ^ E_STRICT);
ini_set('display_errors', 1);

// enable the debug mode
$app['debug'] = true;

// $app->register(new MonologServiceProvider(), array(
//     'monolog.logfile' => __DIR__.'/../var/logs/silex_dev.log',
// ));

// $app->register(new WebProfilerServiceProvider(), array(
//     'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
// ));
