<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\ResourceModel\Entity;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\ResourceModel\EntityTableNameResolverInterface;

/**
 * Table name resolver for entity type tables
 *
 * @author Roman Tomchak <roman@ainnomix.com>
 */
class TableNameResolver implements EntityTableNameResolverInterface
{

    /**
     * {@inheritDoc}
     */
    public function resolve(EntityTypeInterface $entityType): string
    {
        return sprintf('etm_%s_entity', $entityType->getEntityTypeCode());
    }
}
