<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType\Command\Save;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as Resource;

class Update implements OperationInterface
{

    /**
     * @var Resource
     */
    private $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function execute(EntityTypeInterface $entityType): void
    {
        $this->resource->save($entityType);
    }
}
