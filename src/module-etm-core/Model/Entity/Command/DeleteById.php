<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class DeleteById implements DeleteByIdInterface
{

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType, int $entityId): void
    {
        // TODO: Implement execute() method.
    }
}
