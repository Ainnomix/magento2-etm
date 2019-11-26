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

namespace Ainnomix\EtmCore\Model\EntityType\Validator;

use Zend_Validate_Callback;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\EntityTypeValidatorInterface;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType;

class ExistenceValidator implements EntityTypeValidatorInterface
{

    /**
     * @var EntityType
     */
    private $resource;

    /**
     * @var ValidationResultFactory
     */
    private $resultFactory;

    public function __construct(
        EntityType $resource,
        ValidationResultFactory $resultFactory
    ) {
        $this->resource = $resource;
        $this->resultFactory = $resultFactory;
    }

    public function validate(EntityTypeInterface $entityType): ValidationResult
    {
        $callback = function (EntityTypeInterface $entityType) {
            return $this->resource->validateCodeExistence($entityType);
        };

        $validator = new Zend_Validate_Callback($callback);
        $validator->setMessage(
            __('Entity type with the same code already exists.'),
            \Zend_Validate_Callback::INVALID_VALUE
        );

        $errors = [];
        if (!$validator->isValid($entityType)) {
            $errors = $validator->getMessages();
        }

        return $this->resultFactory->create(['errors' => $errors]);
    }
}
