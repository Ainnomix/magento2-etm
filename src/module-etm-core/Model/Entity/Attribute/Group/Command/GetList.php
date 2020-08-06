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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Group\Command;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory;
use Ainnomix\EtmCore\Api\Data\AttributeGroupSearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupSearchResultsInterfaceFactory;

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
     * @var AttributeGroupSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory,
        SearchCriteriaBuilder $criteriaBuilder,
        AttributeGroupSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(SearchCriteriaInterface $criteria = null): AttributeGroupSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        if (null === $criteria) {
            $criteria = $this->criteriaBuilder->create();
        }

        $this->collectionProcessor->process($criteria, $collection);

        /** @var AttributeGroupSearchResultsInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($criteria);

        return $searchResult;
    }
}
