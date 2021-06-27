<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class GetList implements GetListInterface
{

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType, SearchCriteriaInterface $criteria = null): EntitySearchResultsInterface
    {
        // TODO: Implement execute() method.
    }
}
