<?php

namespace Estaty\Test\Model\Location;

use Estaty\Test\TestCase;
use Estaty\Model\Location\City;
use Estaty\Model\Location\Country;

/**
 * @coversDefaultClass Estaty\Model\Location\Country
 */
class CountryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->country = new Country(
            'United Kingdom',
            'GB',
            'en-gb',
            'GBP',
            'sqm'
        );
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorMinimum()
    {
        $country = new Country('United Kingdom', 'GB');
        $this->assertSame('United Kingdom', $country->getName());
        $this->assertSame('GB', $country->getShortCode());
        $this->assertInstanceOf(
            '\Doctrine\Common\Collections\ArrayCollection',
            $country->getCities()
        );
        $this->assertCount(0, $country->getCities());
        $this->assertNull($country->getLanguageCode());
        $this->assertNull($country->getDefaultCurrency());
        $this->assertNull($country->getAreaUnit());
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorMaximum()
    {
        $country = new Country('United Kingdom', 'GB', 'en-gb', 'GBP', 'sqm');
        $this->assertSame('United Kingdom', $country->getName());
        $this->assertSame('GB', $country->getShortCode());
        $this->assertInstanceOf(
            '\Doctrine\Common\Collections\ArrayCollection',
            $country->getCities()
        );
        $this->assertCount(0, $country->getCities());
        $this->assertSame('en-gb', $country->getLanguageCode());
        $this->assertSame('GBP', $country->getDefaultCurrency());
        $this->assertSame('sqm', $country->getAreaUnit());
    }

    /**
     * @covers ::getId
     */
    public function testGetId()
    {
        $this->assertNull($this->country->getId());
    }

    /**
     * @covers ::getName
     */
    public function testGetName()
    {
        $this->assertEquals('United Kingdom', $this->country->getName());
    }

    /**
     * @covers ::getShortCode
     */
    public function testGetShortCode()
    {
        $this->assertEquals('GB', $this->country->getShortCode());
    }

    /**
     * @covers ::getLanguageCode
     */
    public function testGetLanguageCode()
    {
        $this->assertEquals('en-gb', $this->country->getLanguageCode());
    }

    /**
     * @covers ::getDefaultCurrency
     */
    public function testGetDefaultCurrency()
    {
        $this->assertEquals('GBP', $this->country->getDefaultCurrency());
    }

    /**
     * @covers ::getAreaUnit
     */
    public function testGetAreaUnit()
    {
        $this->assertEquals('sqm', $this->country->getAreaUnit());
    }

    /**
     * @covers ::getCities
     */
    public function testGetCities()
    {
        $city = new City('London', $this->country);
        $this->assertCount(1, $this->country->getCities());
        $this->assertTrue($this->country->getCities()->contains($city));
    }
}
