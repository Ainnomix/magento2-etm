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

namespace Ainnomix\EtmApi\Api;

use Ainnomix\EtmApi\Api\Data\EntityTypeSearchResultsInterface;

/**
 * Entity type repository interface
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmApi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
interface EntityTypeRepositoryInterface
{

    /**
     * Retrieve entity types list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     *
     * @return EntityTypeSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria): EntityTypeSearchResultsInterface;
}
