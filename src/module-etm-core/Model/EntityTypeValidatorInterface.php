<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Validation\ValidationResult;

interface EntityTypeValidatorInterface
{

    /**
     * @param EntityTypeInterface $entityType
     *
     * @return ValidationResult
     */
    public function validate(EntityTypeInterface $entityType): ValidationResult;
}
