<?php

namespace Estaty\Test;

use Silex\WebTestCase;

class TestCase extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../src/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();
        return $app;
    }
}
