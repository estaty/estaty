<?php

use Estaty\Controller\AuthController;
use Estaty\Controller\HomepageController;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\ServiceControllerServiceProvider;

if (!isset($app)) {
    // This file should only be loaded after the Silex app is created
    return;
}

$app->register(new ServiceControllerServiceProvider());

// Include the authentication and authorization configuration
require __DIR__.'/../config/auth.php';

$app['homepage.controller'] = $app->share(function() {
    return new HomepageController();
});
$app['auth.controller'] = $app->share(function() use ($app) {
    return new AuthController($app);
});

$app->before(function (Request $request) use ($app) {
    $token = $app['security']->getToken();
    $app['user'] = null;

    if ($token && !$app['security.trust_resolver']->isAnonymous($token)) {
        $app['user'] = $token->getUser();
    }
});

$app->get('/', 'homepage.controller:show')->bind('homepage');
$app->get('/login', 'auth.controller:loginForm')->bind('login');
$app->post('/login', 'auth.controller:loginOrSignupCheck')->bind('loginOrSignupCheck');
$app->post('/users', 'auth.controller:createUser')->bind('signup');
$app->match('/logout', function () {})->bind('logout');
