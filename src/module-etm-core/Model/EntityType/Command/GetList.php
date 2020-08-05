<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType\Command;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterfaceFactory;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * Find Entity types by SearchCriteria command
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 */
class GetList implements GetListInterface
{

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var EntityTypeSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * GetList Command constructor
     *
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CollectionFactory $collectionFactory
     * @param EntityTypeSearchResultsInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory,
        EntityTypeSearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(SearchCriteriaInterface $criteria = null): EntityTypeSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        if (null === $criteria) {
            $criteria = $this->searchCriteriaBuilder->create();
        }

        $this->collectionProcessor->process($criteria, $collection);
        $collection->addFieldToFilter('is_custom', 1);

        $items = [];
        foreach ($collection as $item) {
            $items[] = $item->getDataModel();
        }

        /** @var EntityTypeSearchResultsInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($items);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($criteria);
        return $searchResult;
    }
}
