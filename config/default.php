<?php

use Silex\Provider\UrlGeneratorServiceProvider;

require 'twig.php';
require 'db.php';

$app->register(new UrlGeneratorServiceProvider());

// Load environment and relevant configuration
$environment = getenv('ESTATY_ENV') ?: 'prod';
require __DIR__.'/../config/'.$environment.'.php';
unset($environment);

require 'errors.php';
