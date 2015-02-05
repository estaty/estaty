<?php

use Silex\Provider;

if ('cli' !== PHP_SAPI and true === $app['debug']) {
    $app->register(new Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
    ));
}
