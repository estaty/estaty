<?php

namespace Estaty\Model\Location;

/**
 * @Entity
 */
class City
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ManyToOne(targetEntity="Estaty\Model\Location\Country")
     * @JoinColumn(name="countryId")
     * @var Country
     */
    private $country;

    public function __construct($name, Country $country)
    {
        $this->name = $name;
        $this->country = $country;

        $this->country->getCities()->add($this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCountry()
    {
        return $this->country;
    }
}
