<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Set\Command;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory;
use Ainnomix\EtmCore\Api\Data\AttributeSetSearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetSearchResultsInterfaceFactory;

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
    private $criteriaBuilder;

    /**
     * @var AttributeSetSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory,
        SearchCriteriaBuilder $criteriaBuilder,
        AttributeSetSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(SearchCriteriaInterface $criteria = null): AttributeSetSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        if (null === $criteria) {
            $criteria = $this->criteriaBuilder->create();
        }

        $this->collectionProcessor->process($criteria, $collection);

        /** @var AttributeSetSearchResultsInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($criteria);

        return $searchResult;
    }
}
