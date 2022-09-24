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

namespace Ainnomix\EtmCore\Model\Entity\Type\Command;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Type as Resource;
use Magento\Framework\Exception\NoSuchEntityException;

class GetById implements GetByIdInterface
{

    /**
     * @param EntityTypeInterfaceFactory $entityTypeFactory
     * @param Resource $resource
     */
    public function __construct(
        protected EntityTypeInterfaceFactory $entityTypeFactory,
        protected Resource $resource
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(int $typeId): EntityTypeInterface
    {
        $entityType = $this->entityTypeFactory->create();
        $this->resource->load($entityType, $typeId);

        if ($entityType->getEntityTypeId() === null) {
            throw new NoSuchEntityException(
                __('There is no entity type with ID "%1". Verify and try again.', $typeId)
            );
        }

        return $entityType;
    }
}
