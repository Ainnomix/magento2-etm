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

namespace Ainnomix\EtmCore\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface EntityTypeSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get entity types list.
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityTypeInterface[]
     */
    public function getItems();

    /**
     * Set entity types list.
     *
     * @param \Ainnomix\EtmCore\Api\Data\EntityTypeInterface[] $items
     *
     * @return self
     */
    public function setItems(array $items);
}
