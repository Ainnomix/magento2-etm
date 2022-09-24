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

class Get implements GetInterface
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
    public function execute(string $typeCode): EntityTypeInterface
    {
        $entityType = $this->entityTypeFactory->create();
        $this->resource->loadByCode($entityType, $typeCode);

        if ($entityType->getEntityTypeId() === null) {
            throw new NoSuchEntityException(__('No such entity type with code "%1"', $typeCode));
        }

        return $entityType;
    }
}
