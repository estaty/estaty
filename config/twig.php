<?php

use Silex\Provider\TwigServiceProvider;

$app->register(new TwigServiceProvider());

$app['twig.path'] = [__DIR__.'/../templates'];
