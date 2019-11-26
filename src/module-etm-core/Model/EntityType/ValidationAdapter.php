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

namespace Ainnomix\EtmCore\Model\EntityType;

use Zend_Validate_Interface;
use Magento\Framework\Validation\ValidationResult;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\EntityTypeValidatorInterface;

class ValidationAdapter implements Zend_Validate_Interface
{

    /**
     * @var EntityTypeValidatorInterface
     */
    private $validator;

    /**
     * @var ValidationResult
     */
    private $validationResult;

    public function __construct(EntityTypeValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validate entity type object
     *
     * @param EntityTypeInterface $value
     *
     * @return bool
     */
    public function isValid($value): bool
    {
        $this->validationResult = $this->validator->validate($value);

        return  $this->validationResult->isValid();
    }

    public function getMessages(): array
    {
        return $this->validationResult->getErrors();
    }
}
