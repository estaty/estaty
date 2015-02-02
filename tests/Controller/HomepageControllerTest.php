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
        $this->assertContains('Hello, Lovely apartment!', $crawler->filter('body')->text());
    }
}
