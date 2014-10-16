<?php

namespace Estaty\Test\Controller;

use Estaty\Test\TestCase;
use Estaty\Controller\HomepageController;

/**
 * @coversDefaultClass Estaty\Controller\HomepageController
 */
class HomepageControllerTest extends TestCase
{
    /**
     * @covers ::show
     */
    public function testShow()
    {
        $controller = new HomepageController();
        $homepage = (string) $controller->show($this->app);
        $this->assertContains('Hello, Lovely apartment!', $homepage);
    }
}
