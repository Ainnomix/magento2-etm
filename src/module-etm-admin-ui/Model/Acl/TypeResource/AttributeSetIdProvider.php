<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Model\Acl\TypeResource;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

class AttributeSetIdProvider implements ProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function get(EntityTypeInterface $entityType): string
    {
        return sprintf(
            '%s::%s_attribute_sets_%s',
            ...[static::MODULE_PREFIX, static::ACL_PREFIX, (string) $entityType->getEntityTypeCode()]
        );
    }
}
