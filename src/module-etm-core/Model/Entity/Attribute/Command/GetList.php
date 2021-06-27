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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Command;

use Ainnomix\EtmCore\Api\Data\AttributeSearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSearchResultInterfaceFactory;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Attribute\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class GetList implements GetListInterface
{

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var AttributeSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        AttributeSearchResultInterfaceFactory $searchResultFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(SearchCriteriaInterface $criteria = null): AttributeSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        if (null === $criteria) {
            $criteria = $this->searchCriteriaBuilder->create();
        }

        $this->collectionProcessor->process($criteria, $collection);

        /** @var AttributeSearchResultsInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($criteria);

        return $searchResult;
    }
}
