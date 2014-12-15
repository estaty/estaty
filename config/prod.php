<?php

use Silex\Provider\MonologServiceProvider;

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

$app['twig.options'] = ['cache' => __DIR__.'/../var/cache/twig'];

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/log/silex_prod.log',
    'monolog.name' => 'estaty'
));
