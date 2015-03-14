<?php

namespace Estaty\Test\Controller;

/**
 * @coversDefaultClass Estaty\Controller\HomepageController
 */
class HomepageControllerTest extends ControllerTestCase
{
    /**
     * @covers ::show
     */
    public function testShow()
    {
        $crawler = $this->client->request('GET', '/');

        $response = $this->client->getResponse();
        $this->assertTrue($response->isOk());
        $this->assertContains('Hello, World! I am Lovely Apartment!', $crawler->filter('body')->text());
        $this->assertContains('I cost $50.00', $crawler->filter('body')->text());
    }
}
