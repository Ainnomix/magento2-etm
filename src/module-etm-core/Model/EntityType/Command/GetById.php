<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType\Command;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\EntityTypeFactory;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as Resource;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Get Entity Type by typeId command
 */
class GetById implements GetByIdInterface
{

    /**
     * @var EntityTypeFactory
     */
    protected $entityTypeFactory;

    /**
     * @var Resource
     */
    protected $entityTypeResource;

    /**
     * Get Command constructor
     *
     * @param EntityTypeFactory $entityTypeFactory
     * @param Resource $entityTypeResource
     */
    public function __construct(
        EntityTypeFactory $entityTypeFactory,
        Resource $entityTypeResource
    ) {
        $this->entityTypeFactory = $entityTypeFactory;
        $this->entityTypeResource = $entityTypeResource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(int $entityTypeId): EntityTypeInterface
    {
        $entityType = $this->entityTypeFactory->create();
        $this->entityTypeResource->load($entityType, $entityTypeId, 'entity_type_id');

        if (null === $entityType->getId()) {
            throw new NoSuchEntityException(
                __('Entity type with id "%value" does not exist.', ['value' => $entityTypeId])
            );
        }

        return $entityType;
    }
}
