<?php

namespace Estaty\Test;

use Estaty\Application;

/**
 * @coversDefaultClass Estaty\Application
 */
class ApplicationTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testApplicationHasUrlGeneratorTrait()
    {
        $this->assertTrue(
            method_exists($this->app, 'path'),
            'Failed asserting Estaty\Application has the path method'
        );
        $this->assertTrue(
            method_exists($this->app, 'url'),
            'Failed asserting Estaty\Application has the url method'
        );

        $usedTraits = class_uses($this->app);
        $this->assertArrayHasKey('Silex\Application\UrlGeneratorTrait', $usedTraits);
    }

    /**
     * @coversNothing
     */
    public function testApplicationHasTwigTrait()
    {
        $this->assertTrue(
            method_exists($this->app, 'render'),
            'Failed asserting Estaty\Application has the render method'
        );

        $usedTraits = class_uses($this->app);
        $this->assertArrayHasKey('Silex\Application\TwigTrait', $usedTraits);
    }
}
