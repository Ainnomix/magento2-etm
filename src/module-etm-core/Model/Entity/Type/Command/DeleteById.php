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

use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Type as Resource;
use Ainnomix\EtmCore\Setup\EntityTypeSetup;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class DeleteById implements DeleteByIdInterface
{

    public function __construct(
        protected EntityTypeInterfaceFactory $entityTypeFactory,
        protected EntityTypeSetup $entityTypeSetup,
        protected Resource $resource
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(int $typeId): bool
    {
        $entityType = $this->entityTypeFactory->create();
        $this->resource->load($entityType, $typeId, 'entity_type_id');

        if ($entityType->getEntityTypeId() === null) {
            throw new NoSuchEntityException(
                __('There is no entity type with ID "%1". Verify and try again.', $typeId)
            );
        }

        try {
            $this->entityTypeSetup->dropEntityTypeTables($entityType);
            $this->resource->delete($entityType);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete entity type. %1', $exception->getMessage()),
                $exception
            );
        }

        return true;
    }
}
