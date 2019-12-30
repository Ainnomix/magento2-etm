<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Model\Acl\Resource;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

class NameProvider
{

    const MODULE_PREFIX = 'Ainnomix_EtmAdminUi';

    const ACL_PREFIX = 'etm';

    public function getMainNodeId(EntityTypeInterface $entityType): string
    {
        return sprintf(
            '%s::%s_%s',
            ...[static::MODULE_PREFIX, static::ACL_PREFIX, (string) $entityType->getEntityTypeCode()]
        );
    }

    public function getEntitiesNodeId(EntityTypeInterface $entityType): string
    {
        return sprintf(
            '%s::%s_entities_%s',
            ...[static::MODULE_PREFIX, static::ACL_PREFIX, (string) $entityType->getEntityTypeCode()]
        );
    }

    /**
     * Generate attribute sets node ID
     *
     * @param EntityTypeInterface $entityType
     *
     * @return string
     */
    public function getAttributesNodeId(EntityTypeInterface $entityType): string
    {
        return sprintf(
            '%s::%s_attributes_%s',
            ...[static::MODULE_PREFIX, static::ACL_PREFIX, (string) $entityType->getEntityTypeCode()]
        );
    }

    /**
     * Generate attribute sets node ID
     *
     * @param EntityTypeInterface $entityType
     *
     * @return string
     */
    public function getAttributeSetsNodeId(EntityTypeInterface $entityType): string
    {
        return sprintf(
            '%s::%s_attribute_sets_%s',
            ...[static::MODULE_PREFIX, static::ACL_PREFIX, (string) $entityType->getEntityTypeCode()]
        );
    }
}
