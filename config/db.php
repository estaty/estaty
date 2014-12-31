<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// the connection configuration
$app['db.options'] = [
    'driver'   => 'pdo_mysql',
    'user'     => 'vagrant',
    'password' => null,
    'dbname'   => 'estaty',
];

$paths = [__DIR__.'/../src/Model'];
$isDevMode = !empty($app['debug']);

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => $app['db.options'],
]);

$app['orm.meta.config'] = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$app['orm.em'] = EntityManager::create($app['db.options'], $app['orm.meta.config']);
