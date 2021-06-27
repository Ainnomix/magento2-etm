<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

interface DeleteByIdInterface
{

    /**
     * Delete entity by ID
     *
     * @param EntityTypeInterface $entityType
     * @param int $entityId
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function execute(EntityTypeInterface $entityType, int $entityId): void;
}
