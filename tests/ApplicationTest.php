<?php

namespace Estaty\Test;

use Estaty\Application;

/**
 * @coversDefaultClass Estaty\Application
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testApplicationHasUrlGeneratorTrait()
    {
        $application = new Application();
        $this->assertTrue(
            method_exists($application, 'path'),
            'Failed asserting Estaty\Application has the path method'
        );
        $this->assertTrue(
            method_exists($application, 'url'),
            'Failed asserting Estaty\Application has the url method'
        );

        $usedTraits = class_uses($application);
        $this->assertArrayHasKey('Silex\Application\UrlGeneratorTrait', $usedTraits);
    }

    /**
     * @coversNothing
     */
    public function testApplicationHasTwigTrait()
    {
        $application = new Application();
        $this->assertTrue(
            method_exists($application, 'render'),
            'Failed asserting Estaty\Application has the render method'
        );

        $usedTraits = class_uses($application);
        $this->assertArrayHasKey('Silex\Application\TwigTrait', $usedTraits);
    }
}
