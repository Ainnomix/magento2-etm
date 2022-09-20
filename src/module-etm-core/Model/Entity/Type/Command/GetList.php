<?php
/**
 * This file is part of the Ainnomix Entity Type Manager package.
 *
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2022 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Type\Command;

use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterfaceFactory;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Type\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class GetList implements GetListInterface
{

    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @var EntityTypeSearchResultsInterfaceFactory
     */
    protected EntityTypeSearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param CollectionProcessorInterface $collectionProcessor
     * @param EntityTypeSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionFactory $collectionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        EntityTypeSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionFactory $collectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function execute(SearchCriteriaInterface $criteria = null): EntityTypeSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        if ($criteria === null) {
            $criteria = $this->searchCriteriaBuilder->create();
        }

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
