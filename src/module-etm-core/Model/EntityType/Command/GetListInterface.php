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

namespace Ainnomix\EtmCore\Model\EntityType\Command;

use Magento\Framework\Api\SearchCriteriaInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;

/**
 * Find Entity types by SearchCriteria command (Service Provider Interface - SPI)
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 */
interface GetListInterface
{

    /**
     * Find Entity types by given SearchCriteria
     * SearchCriteria is not required because load all types is useful case
     *
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return EntityTypeSearchResultsInterface
     */
    public function execute(SearchCriteriaInterface $criteria = null): EntityTypeSearchResultsInterface;
}
