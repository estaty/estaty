<?php

namespace Estaty\Test\Controller;

use Estaty\Controller\AuthController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @coversDefaultClass Estaty\Controller\AuthController
 */
class AuthControllerTest extends ControllerTestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $controller = new AuthController($this->app);
        $this->assertInstanceOf('Estaty\Controller\AuthController', $controller);
    }

    /**
     * @covers ::loginForm
     */
    public function testLoginFormLoggedOut()
    {
        $crawler = $this->client->request('GET', '/login');

        $response = $this->client->getResponse();
        $this->assertTrue($response->isOk());

        $this->assertCount(1, $crawler->selectLink('Log in with Facebook'));
        $this->assertCount(1, $crawler->selectLink('Log in with Google'));
        $this->assertCount(1, $crawler->selectLink('Log in with GitHub'));
        $this->assertCount(1, $crawler->filter('form'));
    }
}
