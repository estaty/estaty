<?php

error_reporting(E_ALL);

date_default_timezone_set('UTC');

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Estaty\\Test\\', __DIR__);
