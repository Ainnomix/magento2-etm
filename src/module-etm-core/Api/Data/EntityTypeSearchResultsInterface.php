<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_Etm
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Entity type search result interface
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmCore
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
interface EntityTypeSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get entity type  list
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityTypeInterface[]
     */
    public function getItems();

    /**
     * Set entity type list
     *
     * @param \Ainnomix\EtmCore\Api\Data\EntityTypeInterface[] $items
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface
     */
    public function setItems(array $items);
}
