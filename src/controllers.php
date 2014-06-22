<?php

use Estaty\Application;

$app->get('/', function (Application $app) {
    return 'Hello';
})
    ->bind('homepage');
