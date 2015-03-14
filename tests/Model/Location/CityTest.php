<?php

namespace Estaty\Test\Model\Location;

use Estaty\Test\TestCase;
use Estaty\Model\Location\City;
use Estaty\Model\Location\Country;

/**
 * @coversDefaultClass Estaty\Model\Location\City
 */
class CityTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->country = new Country('United Kingdom', 'GB');
        $this->city = new City('London', $this->country);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $country = new Country('United Kingdom', 'GB');
        $city = new City('London', $country);
        $this->assertSame('London', $city->getName());
        $this->assertSame($country, $city->getCountry());
        $this->assertCount(1, $country->getCities());
        $this->assertTrue($country->getCities()->contains($city));
    }

    /**
     * @covers ::getId
     */
    public function testGetId()
    {
        $this->assertNull($this->city->getId());
    }

    /**
     * @covers ::getName
     */
    public function testGetName()
    {
        $this->assertEquals('London', $this->city->getName());
    }

    /**
     * @covers ::getCountry
     */
    public function testGetCountry()
    {
        $this->assertSame($this->country, $this->city->getCountry());
    }
}
