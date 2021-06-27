<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface GetByIdInterface
{

    /**
     * Get entity by given entityId
     *
     * @param EntityTypeInterface $entityType
     * @param int $entityId
     *
     * @return EntityInterface
     *
     * @throws NoSuchEntityException
     */
    public function execute(EntityTypeInterface $entityType, int $entityId): EntityInterface;
}
