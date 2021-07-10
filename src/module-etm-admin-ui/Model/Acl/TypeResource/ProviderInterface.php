<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Model\Acl\TypeResource;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

interface ProviderInterface
{

    const MODULE_PREFIX = 'Ainnomix_EtmAdminUi';

    const ACL_PREFIX = 'etm';

    /**
     * Generate ACL resource name
     *
     * @param EntityTypeInterface $entityType Entity type instance
     *
     * @return string
     */
    public function get(EntityTypeInterface $entityType): string;
}
