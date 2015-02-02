<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// See http://silex.sensiolabs.org/doc/cookbook/error_handler.html
ErrorHandler::register();
ExceptionHandler::register($app['debug']);
