<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

$app['twig.options'] = ['cache' => __DIR__.'/../var/cache/twig'];
