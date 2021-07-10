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

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class GetList implements GetListInterface
{

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType, SearchCriteriaInterface $criteria = null): EntitySearchResultsInterface
    {
        // TODO: Implement execute() method.
    }
}
