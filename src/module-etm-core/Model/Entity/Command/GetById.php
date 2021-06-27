<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GetById implements GetByIdInterface
{

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType, int $entityId): EntityInterface
    {
        // TODO: Implement execute() method.
    }
}
