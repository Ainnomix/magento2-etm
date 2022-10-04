<?php
/**
 * This file is part of the Ainnomix Entity Type Manager package.
 *
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2022 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use InvalidArgumentException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class TypeManager
{

    /**
     * @var EntityTypeInterface[]
     */
    protected $objects = [];

    /**
     * @param EntityTypeRepositoryInterface $entityTypeRepository
     */
    public function __construct(
        protected EntityTypeRepositoryInterface $entityTypeRepository
    ) {
    }

    /**
     * Get entity type by code
     *
     * @param EntityTypeInterface|string $entityType
     *
     * @return EntityTypeInterface
     *
     * @throws InvalidArgumentException|NoSuchEntityException|LocalizedException
     */
    public function getEntityType(EntityTypeInterface|string $entityType): EntityTypeInterface
    {
        if ($entityType instanceof EntityTypeInterface) {
            return $entityType;
        }

        if (!is_string($entityType)) {
            throw new InvalidArgumentException(
                sprintf('Entity type must extend %s or string', EntityTypeInterface::class)
            );
        }

        if (!array_key_exists($entityType, $this->objects)) {
            return $this->objects[$entityType] = $this->entityTypeRepository->get($entityType);
        }

        return $this->objects[$entityType];
    }
}
