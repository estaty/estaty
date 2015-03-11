<?php

namespace Estaty\Test\Model\Property;

use Estaty\Test\TestCase;
use Estaty\Model\Property\PropertyType;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @coversDefaultClass Estaty\Model\Property\PropertyType
 */
class PropertyTypeTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->propertyType = new PropertyType(
            'Apartment',
            'apartment'
        );

        $this->childPropertyType = new PropertyType(
            'Room',
            'room',
            $this->propertyType
        );
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorMinimum()
    {
        $propertyType = new PropertyType('House', 'house');
        $this->assertSame('House', $propertyType->getName());
        $this->assertSame('house', $propertyType->getSlug());
        $this->assertNull($propertyType->getParent());
        $this->assertInstanceOf(
            '\Doctrine\Common\Collections\ArrayCollection',
            $propertyType->getChildren()
        );
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorWithParent()
    {
        $parentPropertyType = new PropertyType('House Complex', 'house-complex');
        $propertyType = new PropertyType('House', 'house', $parentPropertyType);
        $this->assertSame('House', $propertyType->getName());
        $this->assertSame('house', $propertyType->getSlug());
        $this->assertSame($parentPropertyType, $propertyType->getParent());
        $this->assertInstanceOf(
            '\Doctrine\Common\Collections\ArrayCollection',
            $propertyType->getChildren()
        );
    }

    /**
     * @covers ::getId
     */
    public function testGetId()
    {
        $this->assertNull($this->propertyType->getId());
    }

    /**
     * @covers ::getName
     */
    public function testGetName()
    {
        $this->assertEquals('Apartment', $this->propertyType->getName());
    }

    /**
     * @covers ::getSlug
     */
    public function testGetSlug()
    {
        $this->assertEquals('apartment', $this->propertyType->getSlug());
    }

    /**
     * @covers ::getParent
     */
    public function testGetParent()
    {
        $this->assertNull($this->propertyType->getParent());
        $this->assertSame(
            $this->propertyType,
            $this->childPropertyType->getParent()
        );
    }

    /**
     * @covers ::getChildren
     */
    public function testGetChildren()
    {
        $this->assertInstanceOf(
            '\Doctrine\Common\Collections\ArrayCollection',
            $this->propertyType->getChildren()
        );
        $this->assertCount(0, $this->childPropertyType->getChildren());
        $this->assertCount(1, $this->propertyType->getChildren());
    }

    /**
     * @covers ::getRoot
     */
    public function testGetRoot()
    {
        $this->assertSame($this->propertyType, $this->propertyType->getRoot());
        $this->assertSame($this->propertyType, $this->childPropertyType->getRoot());
    }
}
