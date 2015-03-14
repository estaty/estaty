<?php

namespace Estaty\Model\Location;

use Estaty\Model\Location\City;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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

    /**
     * @param City   $city
     * @param string $address
     */
    public function __construct(City $city, $address)
    {
        $this->setCity($city);
        $this->setAddress($address);
    }

    /**
     * @codeCoverageIgnore
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('city', [
            new Assert\NotBlank(),
        ]);

        $metadata->addPropertyConstraints('address', [
            new Assert\NotBlank(),
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity(City $city)
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry()
    {
        return $this->city->getCountry();
    }

    public function getPostCode()
    {
        return $this->postCode;
    }

    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }
}
