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

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

/**
 * Interface for entity table name resolvers classes
 *
 * @author Roman Tomchak <roman@ainnomix.com>
 */
interface EntityTableNameResolverInterface
{

    /**
     * Generate entity type table name
     *
     * @param EntityTypeInterface $entityType
     *
     * @return string
     */
    public function resolve(EntityTypeInterface $entityType): string;
}
