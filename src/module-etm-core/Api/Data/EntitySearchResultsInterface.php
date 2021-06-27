<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface EntitySearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get entity type  list
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityInterface[]
     */
    public function getItems();

    /**
     * Set entity type list
     *
     * @param \Ainnomix\EtmCore\Api\Data\EntityInterface[] $items
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface
     */
    public function setItems(array $items);
}
