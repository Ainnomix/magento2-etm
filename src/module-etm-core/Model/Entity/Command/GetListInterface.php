<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface GetListInterface
{

    /**
     * Find entities by given SearchCriteria
     *
     * @param EntityTypeInterface $entityType
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return EntitySearchResultsInterface
     */
    public function execute(EntityTypeInterface $entityType, SearchCriteriaInterface $criteria = null): EntitySearchResultsInterface;
}
