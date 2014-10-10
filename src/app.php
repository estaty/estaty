<?php

use Estaty\Application;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
// use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

// Use Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();

$app->register(new UrlGeneratorServiceProvider());
// $app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());

// include the default configuration
require __DIR__.'/../config/default.php';

$environment = getenv('ESTATY_ENV') ?: 'prod';
require __DIR__.'/../config/'.$environment.'.php';
unset($environment);

// http://silex.sensiolabs.org/doc/cookbook/error_handler.html
ErrorHandler::register();
ExceptionHandler::register($app['debug']);

$app->register(new UrlGeneratorServiceProvider());
// $app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
// $app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
//     // add custom globals, filters, tags, ...

//     return $twig;
// }));

return $app;
