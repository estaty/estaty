<?php

use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

require 'twig.php';
require 'db.php';

$app->register(new UrlGeneratorServiceProvider());

$app->register(new TranslationServiceProvider(), [
    'locale_fallbacks' => ['en'],
    'domains' => [
        'messages' => [
            'en' => [
                'hello' => 'Hello, %name%',
            ],
        ],
        'validators' => [
            'en' => [
                'hello' => 'Hello, %name%',
            ],
        ],
        'properties' => [
            'en' => [
                'hello' => 'Hello, %name%',
            ],
        ],
    ],
]);

$app['validator.unique'] = $app->share(function($app) {
    return new Estaty\Validator\Constraints\UniqueEntityValidator($app['orm.em']);
});

$app->register(new ValidatorServiceProvider(), [
    'validator.validator_factory' => $app->share(function($app) {
        return new Silex\ConstraintValidatorFactory($app, [
            'doctrine.orm.validator.unique' => 'validator.unique',
        ]);
    }),
]);

// Load environment and relevant configuration
$environment = getenv('ESTATY_ENV') ?: 'prod';
require __DIR__.'/../config/'.$environment.'.php';
unset($environment);

require 'errors.php';
