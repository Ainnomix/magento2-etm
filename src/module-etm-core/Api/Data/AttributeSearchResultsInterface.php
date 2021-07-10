<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AttributeSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get items list.
     *
     * @return AttributeInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param AttributeInterface[] $items
     *
     * @return AttributeSearchResultsInterface
     */
    public function setItems(array $items);
}
