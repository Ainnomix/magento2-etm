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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Set\Command;

use Ainnomix\EtmCore\Api\Data\AttributeSetSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface GetListInterface
{

    /**
     * Find attribute sets by given SearchCriteria
     * SearchCriteria is not required because load all types is useful case
     *
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return AttributeSetSearchResultsInterface
     */
    public function execute(SearchCriteriaInterface $criteria = null): AttributeSetSearchResultsInterface;
}
