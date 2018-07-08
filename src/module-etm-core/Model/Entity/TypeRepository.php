<?php

namespace Ainnomix\EtmCore\Model\Entity;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;

class TypeRepository implements EntityTypeRepositoryInterface
{

    /**
     * @var \Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory
     */
    private $entityTypeFactory;

    /**
     * @var \Ainnomix\EtmCore\Model\ResourceModel\Entity\Type
     */
    private $resourceModel;

    public function __construct(
        \Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory $entityTypeFactory,
        \Ainnomix\EtmCore\Model\ResourceModel\Entity\Type $resourceModel
    ) {
        $this->entityTypeFactory = $entityTypeFactory;
        $this->resourceModel = $resourceModel;
    }

    public function save(EntityTypeInterface $entityType): EntityTypeInterface
    {

    }

    public function get(string $entityTypeCode): EntityTypeInterface
    {

    }

    public function getById(int $entityTypeId): EntityTypeInterface
    {
        throw new NoSuchEntityException();
    }

    public function delete(EntityTypeInterface $entityType)
    {

    }

    public function getList(SearchCriteriaInterface $searchCriteria): EntityTypeSearchResultsInterface
    {

    }
}
