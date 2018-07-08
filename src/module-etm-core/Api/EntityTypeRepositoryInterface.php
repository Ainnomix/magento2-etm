<?php

namespace Ainnomix\EtmCore\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;

interface EntityTypeRepositoryInterface
{

    public function save(EntityTypeInterface $entityType): EntityTypeInterface;

    public function get(string $entityTypeCode): EntityTypeInterface;

    public function getById(int $entityTypeId): EntityTypeInterface;

    public function delete(EntityTypeInterface $entityType);

    public function getList(SearchCriteriaInterface $searchCriteria): EntityTypeSearchResultsInterface;
}
