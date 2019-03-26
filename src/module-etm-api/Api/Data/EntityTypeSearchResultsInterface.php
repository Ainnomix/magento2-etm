<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_Etm
 * @package   Ainnomix\EtmApi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmApi\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Entity type search result interface
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmApi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
interface EntityTypeSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get entity type  list
     *
     * @return \Ainnomix\EtmApi\Api\Data\EntityTypeInterface[]
     */
    public function getItems(): array;

    /**
     * Set entity type list
     *
     * @param \Ainnomix\EtmApi\Api\Data\EntityTypeInterface[] $items
     *
     * @return \Ainnomix\EtmApi\Api\Data\EntityTypeSearchResultsInterface
     */
    public function setItems(array $items): EntityTypeSearchResultsInterface;
}
