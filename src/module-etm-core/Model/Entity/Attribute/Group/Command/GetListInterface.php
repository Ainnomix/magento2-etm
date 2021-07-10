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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Group\Command;

use Ainnomix\EtmCore\Api\Data\AttributeGroupSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface GetListInterface
{

    /**
     * Find attribute groups by given SearchCriteria
     * SearchCriteria is not required because load all types is useful case
     *
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return AttributeGroupSearchResultsInterface
     */
    public function execute(SearchCriteriaInterface $criteria = null): AttributeGroupSearchResultsInterface;
}
