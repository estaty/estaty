<?php

namespace Estaty\Test\Controller;

use Estaty\Model\User;
use Estaty\Test\TestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @coversDefaultClass Estaty\Controller\AuthController
 */
class ControllerTestCase extends TestCase
{
    /**
     * @var Symfony\Component\HttpKernel\Client
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $app = $this->app;
        require __DIR__.'/../../src/controllers.php';
        $this->app = $app;
        $this->app['session.test'] = true;
        $this->client = $this->createClient();
    }
}
