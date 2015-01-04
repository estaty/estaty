<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

if (file_exists(__DIR__.'/secret/db.'.$app['env'].'.php')) {
    include_once __DIR__.'/secret/db.'.$app['env'].'.php';
} else {
    include_once __DIR__.'/secret/db.php';
}

// the connection configuration
$app['db.options'] = [
    'driver'   => DB_DRIVER,
    'user'     => DB_USER,
    'password' => DB_PASSWORD,
    'dbname'   => DB_NAME,
];

$paths = [__DIR__.'/../src/Model'];
$isDevMode = !empty($app['debug']);

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => $app['db.options'],
]);

$app['orm.meta.config'] = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$app['orm.em'] = EntityManager::create($app['db.options'], $app['orm.meta.config']);
