<?php

namespace Estaty\Model\Property;

use Estaty\Model\User;
use Estaty\Model\Location\Location;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity @HasLifecycleCallbacks
 */
class Property
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    private $name;

    /**
     * @ManyToOne(targetEntity="PropertyType")
     * @JoinColumn(name="primaryTypeId", referencedColumnName="id")
     * @var Estaty\Model\Property\PropertyType
     */
    private $primaryType;

    /**
     * @ManyToOne(targetEntity="PropertyType")
     * @JoinColumn(name="typeId", referencedColumnName="id")
     * @var Estaty\Model\Property\PropertyType
     */
    private $type;

    /**
     * @ManyToOne(targetEntity="Estaty\Model\User", inversedBy="properties")
     * @JoinColumn(name="creatorId", referencedColumnName="id")
     * @var Estaty\Model\User
     */
    private $creator;

    /**
     * @ManyToOne(targetEntity="Estaty\Model\Location\Location")
     * @JoinColumn(name="locationId")
     */
    private $location;

    /**
     * @Column(type="decimal", precision=12, scale=2)
     * @var float
     */
    private $price;

    /**
     * @Column(type="decimal", precision=12, scale=2)
     * @var float
     */
    private $priceUsd;

    /**
     * @Column(type="string", length=3)
     * @var string
     */
    private $currency;

    /**
     * @Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $area;

    /**
     * @Column(type="string", nullable=true)
     */
    private $areaUnit;

    /**
     * @Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $areaMeters;

    /**
     * @param string $primaryType
     */
    public function __construct(PropertyType $type)
    {
        $this->setType($type);
    }

    /**
     * @codeCoverageIgnore
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('primaryType', [
            new Assert\NotBlank(),
        ]);

        $metadata->addPropertyConstraints('name', [
            new Assert\Length([
                'max' => 150,
            ]),
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPrimaryType()
    {
        return $this->primaryType;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(PropertyType $type)
    {
        $this->type = $type;
        $this->setPrimaryTypeFromType();

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @PrePersist
     */
    public function setPrimaryTypeFromType()
    {
        $this->primaryType = $this->type->getRoot();
    }

    public function isType(PropertyType $type)
    {
        if ($type->getSlug() === $this->type->getSlug()) {
            return true;
        }

        if (!$this->type->getParent()) {
            return false;
        }

        return $type->getSlug() === $this->type->getParent()->getSlug();
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setCreator(User $user)
    {
        $this->creator = $user;

        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation(Location $location)
    {
        $this->location = $location;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceUsd()
    {
        return $this->priceUsd;
    }

    /**
     * @param float $price
     */
    public function setPriceUsd($priceUsd)
    {
        $this->priceUsd = $priceUsd;

        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param integer $area
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    public function getAreaMeters()
    {
        return $this->areaMeters;
    }

    public function setAreaMeters($areaMeters)
    {
        $this->areaMeters = $areaMeters;

        return $this;
    }

    public function getAreaUnit()
    {
        return $this->areaUnit;
    }

    /**
     * @param string $areaUnit
     */
    public function setAreaUnit($areaUnit)
    {
        $this->areaUnit = $areaUnit;

        return $this;
    }
}
