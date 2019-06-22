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

namespace Ainnomix\EtmAdminUi\Model\Model\Entity\Type;

use Ainnomix\EtmApi\Api\Data\EntityTypeInterface;

/**
 * Entity type data validator
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Validator
{

    public function validate(EntityTypeInterface $entityType): void
    {
        $entityType->validateBeforeSave();
    }
}
