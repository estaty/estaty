<?php

error_reporting(E_ALL);

putenv('ESTATY_ENV=test');

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Estaty\\Test\\', __DIR__);
