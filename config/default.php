<?php

use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

$app['route_class'] = '\\Estaty\\Route';

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
    return new Estaty\Validator\Constraints\UniqueEntityValidator($app);
});

$app->register(new ValidatorServiceProvider(), [
    'validator.validator_factory' => $app->share(function($app) {
        return new Silex\ConstraintValidatorFactory($app, [
            'doctrine.orm.validator.unique' => 'validator.unique',
        ]);
    }),
]);
