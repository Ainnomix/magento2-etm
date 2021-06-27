<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType\Command\Save;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

interface OperationInterface
{

    public function execute(EntityTypeInterface $entityType): void;
}
