<?php

namespace Estaty\Test\Model\Property;

use Estaty\Test\TestCase;
use Estaty\Model\User;
use Estaty\Model\Location\City;
use Estaty\Model\Location\Country;
use Estaty\Model\Location\Location;
use Estaty\Model\Property\Property;
use Estaty\Model\Property\PropertyType;

/**
 * @coversDefaultClass \Estaty\Model\Property\Property
 */
class PropertyTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $type = new PropertyType('house', 'house');
        $property = new Property($type);
        $this->assertSame($type, $property->getType());
    }

    /**
     * @covers ::getId
     */
    public function testGetId()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getId());
    }

    /**
     * @covers ::getName
     */
    public function testGetName()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getName());

        $property->setName('Test property');
        $this->assertEquals('Test property', $property->getName());
    }

    /**
     * @covers ::setName
     */
    public function testSetName()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $property->setName('Test property');
        $this->assertEquals('Test property', $property->getName());

        $property->setName(null);
        $this->assertNull($property->getName());
    }

    /**
     * @covers ::getType
     */
    public function testGetType()
    {
        $type = new PropertyType('house', 'house');
        $property = new Property($type);
        $this->assertSame($type, $property->getType());

        $anotherType = new PropertyType('room', 'room');
        $property->setType($anotherType);
        $this->assertSame($anotherType, $property->getType());
    }

    /**
     * @covers ::setType
     */
    public function testSetType()
    {
        $type = new PropertyType('room', 'room');
        $property = $this->getMock(
            '\Estaty\Model\Property\Property',
            ['setPrimaryTypeFromType'],
            [$type],
            '',
            false,
            true,
            true,
            false,
            true
        );

        $property
            ->expects($this->exactly(1))
            ->method('setPrimaryTypeFromType');

        $property->setType($type);
        $this->assertSame($type, $property->getType());
    }

    /**
     * @covers ::setPrimaryTypeFromType
     * @covers ::getPrimaryType
     */
    public function testSetPrimaryTypeFromType()
    {
        $parentType = new PropertyType('House', 'house');
        $childType = new PropertyType('Room', 'room', $parentType);

        $property = new Property($parentType);

        $this->assertSame($parentType, $property->getType());
        $this->assertSame($parentType, $property->getPrimaryType());

        $property->setType($childType);

        $this->assertSame($childType, $property->getType());
        $this->assertSame($parentType, $property->getPrimaryType());

        $property->setType($parentType);
        $this->assertSame($parentType, $property->getType());
        $this->assertSame($parentType, $property->getPrimaryType());
    }

    /**
     * @covers ::isType
     */
    public function testIsType()
    {
        $parentType = new PropertyType('House', 'house');
        $childType = new PropertyType('Room', 'room', $parentType);
        $otherType = new PropertyType('Apartment', 'apartment');

        $property = new Property($parentType);

        $this->assertTrue($property->isType($parentType));
        $this->assertFalse($property->isType($childType));
        $this->assertFalse($property->isType($otherType));

        $property->setType($childType);
        $this->assertTrue($property->isType($parentType));
        $this->assertTrue($property->isType($childType));
        $this->assertFalse($property->isType($otherType));

        $property->setType($otherType);
        $this->assertFalse($property->isType($parentType));
        $this->assertFalse($property->isType($childType));
        $this->assertTrue($property->isType($otherType));
    }

    /**
     * @covers ::getCreator
     * @covers ::setCreator
     */
    public function testGetAndSetCreator()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getCreator());

        $user = new User('', '', '');
        $property->setCreator($user);
        $this->assertSame($user, $property->getCreator());
    }

    /**
     * @covers ::getLocation
     * @covers ::setLocation
     */
    public function testGetAndSetLocation()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getLocation());

        $uk = new Country('United Kingdom', 'GB');
        $london = new City('London', $uk);
        $location = new Location($london, 'Baker Street 221B');
        $property->setLocation($location);
        $this->assertSame($location, $property->getLocation());
    }

    /**
     * @covers ::getPrice
     * @covers ::setPrice
     */
    public function testGetAndSetPrice()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getPrice());

        $property->setPrice(5.00);
        $this->assertEquals(5.00, $property->getPrice());

        $property->setPrice(null);
        $this->assertNull($property->getPrice());
    }

    /**
     * @covers ::getPriceUsd
     * @covers ::setPriceUsd
     */
    public function testGetAndSetPriceUsd()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getPriceUsd());

        $property->setPriceUsd(5.00);
        $this->assertEquals(5.00, $property->getPriceUsd());

        $property->setPriceUsd(null);
        $this->assertNull($property->getPriceUsd());
    }

    /**
     * @covers ::getCurrency
     * @covers ::setCurrency
     */
    public function testGetAndSetCurrency()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getCurrency());

        $property->setCurrency('USD');
        $this->assertEquals('USD', $property->getCurrency());

        $property->setCurrency(null);
        $this->assertNull($property->getCurrency());
    }

    /**
     * @covers ::getArea
     * @covers ::setArea
     */
    public function testGetAndSetArea()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getArea());

        $property->setArea(50);
        $this->assertEquals(50, $property->getArea());

        $property->setArea(null);
        $this->assertNull($property->getArea());
    }

    /**
     * @covers ::getAreaMeters
     * @covers ::setAreaMeters
     */
    public function testGetAndSetAreaMeters()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getAreaMeters());

        $property->setAreaMeters(50);
        $this->assertEquals(50, $property->getAreaMeters());

        $property->setAreaMeters(null);
        $this->assertNull($property->getAreaMeters());
    }

    /**
     * @covers ::getAreaUnit
     * @covers ::setAreaUnit
     */
    public function testGetAndSetAreaUnit()
    {
        $property = new Property(new PropertyType('house', 'house'));
        $this->assertNull($property->getAreaUnit());

        $property->setAreaUnit('sqm');
        $this->assertEquals('sqm', $property->getAreaUnit());

        $property->setAreaUnit(null);
        $this->assertNull($property->getAreaUnit());
    }
}
