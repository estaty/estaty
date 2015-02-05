<?php

namespace Estaty\Model\Property;

use Estaty\Model\User;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity @HasLifecycleCallbacks
 */
class Property
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
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
    protected $creator;

    /**
     * @param string $primaryType
     */
    public function __construct(PropertyType $type)
    {
        $this->setType($type);
    }

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
        if (!$this->type) {
            return false;
        }

        if ($type->getId() === $this->type->getId()) {
            return true;
        }

        if (!$this->type->parent) {
            return false;
        }

        return $type->getId() === $this->type->parent->getId();
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
}
