<?php

use Estaty\Application;
use Estaty\Controller\HomepageController;

if (!isset($app)) {
    // This file should only be loaded after the Silex app is initialized
    return;
}

$app['homepage.controller'] = $app->share(function() {
    return new HomepageController();
});

$app->get('/', 'homepage.controller:show')
    ->bind('homepage');
