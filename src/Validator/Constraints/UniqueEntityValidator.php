<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Estaty\Validator\Constraints;

use Pimple;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * Unique Entity Validator checks if one or a set of fields contain unique values.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
class UniqueEntityValidator extends ConstraintValidator
{
    /**
     * @var Pimple
     */
    private $container;

    /**
     * @param Pimple $container
     */
    public function __construct(Pimple $container)
    {
        $this->container = $container;
    }

    /**
     * @param object     $entity
     * @param Constraint $constraint
     *
     * @throws UnexpectedTypeException
     * @throws ConstraintDefinitionException
     */
    public function validate($entity, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueEntity) {
            throw new UnexpectedTypeException(
                $constraint,
                'Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity'
            );
        }

        if (false === is_array($constraint->fields) && false === is_string($constraint->fields)) {
            throw new UnexpectedTypeException($constraint->fields, 'array');
        }

        if (null !== $constraint->errorPath && false === is_string($constraint->errorPath)) {
            throw new UnexpectedTypeException($constraint->errorPath, 'string or null');
        }

        $fields = (array) $constraint->fields;

        if (0 === count($fields)) {
            throw new ConstraintDefinitionException('At least one field has to be specified.');
        }

        /**
         * @var Doctrine\ORM\EnityManager
         */
        $em = $this->container['orm.em'];

        /**
         * @var \Doctrine\Common\Persistence\Mapping\ClassMetadata
         */
        $class = $em->getClassMetadata(get_class($entity));

        if (!$class instanceof \Doctrine\ORM\Mapping\ClassMetadataInfo) {
            throw new ConstraintDefinitionException('Entity does not use a supported metadata class.');
        }

        $criteria = array();
        foreach ($fields as $fieldName) {
            if (false === $class->hasField($fieldName) && false === $class->hasAssociation($fieldName)) {
                throw new ConstraintDefinitionException(sprintf(
                    'The field "%s" is not mapped by Doctrine, so it cannot be validated for uniqueness.',
                    $fieldName
                ));
            }

            $criteria[$fieldName] = $class->reflFields[$fieldName]->getValue($entity);

            if (true === $constraint->ignoreNull && null === $criteria[$fieldName]) {
                return;
            }

            if (null !== $criteria[$fieldName] && true === $class->hasAssociation($fieldName)) {
                /* Ensure the Proxy is initialized before using reflection to
                 * read its identifiers. This is necessary because the wrapped
                 * getter methods in the Proxy are being bypassed.
                 */
                $em->initializeObject($criteria[$fieldName]);

                $relatedClass = $em->getClassMetadata($class->getAssociationTargetClass($fieldName));
                $relatedId = $relatedClass->getIdentifierValues($criteria[$fieldName]);

                if (count($relatedId) > 1) {
                    throw new ConstraintDefinitionException(sprintf(
                        'Associated entities are not allowed to have more than one identifier field to be part of a unique constraint in: %s#%s',
                        $class->getName(),
                        $fieldName
                    ));
                }
                $criteria[$fieldName] = array_pop($relatedId);
            }
        }

        $repository = $em->getRepository(get_class($entity));
        $result = $repository->{$constraint->repositoryMethod}($criteria);

        /* If the result is a MongoCursor, it must be advanced to the first
         * element. Rewinding should have no ill effect if $result is another
         * iterator implementation.
         */
        if ($result instanceof \Iterator) {
            $result->rewind();
        } elseif (true === is_array($result)) {
            reset($result);
        }

        /* If no entity matched the query criteria or a single entity matched,
         * which is the same as the entity being validated, the criteria is
         * unique.
         */
        if (0 === count($result) || (1 === count($result)
            && $entity === ($result instanceof \Iterator ? $result->current() : current($result)))) {
            return;
        }

        $errorPath = null !== $constraint->errorPath ? $constraint->errorPath : $fields[0];

        $this->buildViolation($constraint->message)
            ->atPath($errorPath)
            ->setInvalidValue($criteria[$fields[0]])
            ->addViolation();
    }
}
