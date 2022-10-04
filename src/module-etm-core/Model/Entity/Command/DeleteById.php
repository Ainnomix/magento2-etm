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

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Model\ResourceModel\Entity\ResourceRegistry;
use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;

class DeleteById implements DeleteByIdInterface
{

    /**
     * Dependencies injection
     *
     * @param ResourceRegistry $resourceRegistry
     * @param GetByIdInterface $commandGetById
     */
    public function __construct(
        protected ResourceRegistry $resourceRegistry,
        protected GetByIdInterface $commandGetById
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(string $entityType, int $entityId): bool
    {
        $entity = $this->commandGetById->execute($entityType, $entityId);

        try {
            $resource = $this->resourceRegistry->getOrCreate($entityType);
            $resource->delete($entity);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __(sprintf('Could not delete entity with ID "%s"', $entityId)),
                $exception,
                $exception->getCode()
            );
        }

        return true;
    }
}
