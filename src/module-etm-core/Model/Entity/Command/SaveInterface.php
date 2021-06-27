<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotSaveException;

interface SaveInterface
{

    /**
     * Save entity data
     *
     * @param EntityTypeInterface $entityType
     * @param EntityInterface $entity
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function execute(EntityTypeInterface $entityType, EntityInterface $entity): int;
}
