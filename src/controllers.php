<?php

$app->get('/', function () use ($app) {
    return 'Hello';
})
    ->bind('homepage');