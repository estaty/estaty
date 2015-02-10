<?php

namespace Estaty\Model\Location;

/**
 * @Entity
 */
class Country
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var integer
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @Column(type="string", unique=true)
     * @var string
     */
    private $shortCode;

    /**
     * @Column(type="string")
     * @var string
     */
    private $languageCode;

    /**
     * @Column(type="string")
     * @var string
     */
    private $defaultCurrency;

    /**
     * @Column(type="string")
     * @var string
     */
    private $areaUnit;

    /**
     * @OneToMany(targetEntity="Estaty\Model\Location\City", mappedBy="country")
     */
    private $cities;

    /**
     * @param string $name
     * @param string $shortCode
     * @param string $languageCode
     * @param string $defaultCurrency
     * @param string $areaUnit
     */
    public function __construct($name, $shortCode, $languageCode = null, $defaultCurrency = null, $areaUnit = null)
    {
        $this->name = $name;
        $this->shortCode = $shortCode;
        $this->languageCode = $languageCode;
        $this->defaultCurrency = $defaultCurrency;
        $this->areaUnit = $areaUnit;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getShortCode()
    {
        return $this->shortCode;
    }

    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    public function getAreaUnit()
    {
        return $this->areaUnit;
    }

    public function getCities()
    {
        return $this->cities;
    }
}
