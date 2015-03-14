<?php

namespace Estaty\Test\Model\Location;

use Estaty\Test\TestCase;
use Estaty\Model\Location\City;
use Estaty\Model\Location\Country;
use Estaty\Model\Location\Location;

/**
 * @coversDefaultClass Estaty\Model\Location\Location
 */
class LocationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->country = new Country('United Kingdom', 'GB');
        $this->city = new City('London', $this->country);
        $this->location = new Location($this->city, 'Baker Street 221B');
    }

    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $country = new Country('United Kingdom', 'GB');
        $city = new City('London', $country);
        $location = new Location($city, 'Baker Street 221B');
        $this->assertSame($city, $location->getCity());
        $this->assertSame('Baker Street 221B', $location->getAddress());
    }

    /**
     * @covers ::getId
     */
    public function testGetId()
    {
        $this->assertNull($this->location->getId());
    }

    /**
     * @covers ::getCity
     * @covers ::setCity
     */
    public function testGetAndSetCity()
    {
        $this->assertSame($this->city, $this->location->getCity());

        $city = new City('Liverpool', $this->country);
        $this->location->setCity($city);
        $this->assertSame($city, $this->location->getCity());
    }

    /**
     * @covers ::getCountry
     */
    public function testGetCountry()
    {
        $this->assertSame($this->country, $this->location->getCountry());

        $spain = new Country('Spain', 'ES');
        $barcelona = new City('Barcelona', $spain);
        $this->location->setCity($barcelona);
        $this->assertSame($spain, $this->location->getCountry());

    }

    /**
     * @covers ::getAddress
     * @covers ::setAddress
     */
    public function testGetAndSetAddress()
    {
        $this->assertSame('Baker Street 221B', $this->location->getAddress());

        $this->location->setAddress('Tower of London');
        $this->assertSame('Tower of London', $this->location->getAddress());
    }

    /**
     * @covers ::getPostCode
     * @covers ::setPostCode
     */
    public function testGetAndSetPostCode()
    {
        $this->assertNull($this->location->getPostCode());

        $this->location->setPostCode('XXX');
        $this->assertSame('XXX', $this->location->getPostCode());
    }

    /**
     * @covers ::getLatitude
     * @covers ::setLatitude
     */
    public function testGetAndSetLatitude()
    {
        $this->assertNull($this->location->getLatitude());

        $this->location->setLatitude(95.76);
        $this->assertSame(95.76, $this->location->getLatitude());
    }

    /**
     * @covers ::getLongitude
     * @covers ::setLongitude
     */
    public function testGetAndSetLongitude()
    {
        $this->assertNull($this->location->getLongitude());

        $this->location->setLongitude(35.30);
        $this->assertSame(35.30, $this->location->getLongitude());
    }
}
