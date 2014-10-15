<?php

namespace Estaty\Test;

use Silex\WebTestCase;

class TestCase extends WebTestCase
{
    public function createApplication()
    {
        return require __DIR__.'/../src/app.php';
    }
}
