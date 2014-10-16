<?php

namespace Estaty\Test\Model\Property;

use Estaty\Test\TestCase;
use Estaty\Model\Property\Room;

/**
 * @coversDefaultClass Estaty\Model\Property\Property
 */
class PropertyTest extends TestCase
{
    /**
     * @covers ::getId
     */
    public function testGetId()
    {
        $property = new Room();
        $this->assertNull($property->getId());
    }

    /**
     * @covers ::getName
     */
    public function testGetName()
    {
        $property = new Room();
        $this->assertNull($property->getName());

        $property->setName('Test property');
        $this->assertEquals('Test property', $property->getName());
    }

    /**
     * @covers ::setName
     */
    public function testSetName()
    {
        $property = new Room();
        $property->setName('Test property');
        $this->assertEquals('Test property', $property->getName());

        $property->setName(null);
        $this->assertNull($property->getName());
    }
}
