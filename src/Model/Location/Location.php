<?php

namespace Estaty\Model\Location;

/**
 * @Entity
 */
class Location
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var integer
     */
    private $id;


    /**
     * @ManyToOne(targetEntity="Estaty\Model\Location\Country")
     * @JoinColumn(name="countryId")
     * @var Country
     */
    private $country;

    /**
     * @ManyToOne(targetEntity="Estaty\Model\Location\City")
     * @JoinColumn(name="cityId")
     * @var City
     */
    private $city;

    /**
     * @Column(type="string")
     * @var string
     */
    private $postCode;

    /**
     * @Column(type="string")
     * @var string
     */
    private $address;

    /**
     * @Column(type="decimal", nullable=true, precision=9, scale=3)
     * @var double
     */
    private $latitude;

    /**
     * @Column(type="decimal", nullable=true, precision=9, scale=3)
     * @var double
     */
    private $longitude;

    public function getId()
    {
        return $this->id;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getPostCode()
    {
        return $this->postCode;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
}
