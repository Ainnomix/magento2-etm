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
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Validation\ValidationResult;
use Ainnomix\EtmCore\Model\EntityType;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Model\EntityTypeValidatorInterface;

class ValidationAdapter implements Zend_Validate_Interface
{

    /**
     * @var EntityTypeValidatorInterface
     */
    private $validator;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var EntityTypeInterfaceFactory
     */
    private $entityTypeFactory;

    /**
     * @var ValidationResult
     */
    private $validationResult;

    public function __construct(
        EntityTypeValidatorInterface $validator,
        DataObjectHelper $dataObjectHelper,
        EntityTypeInterfaceFactory $entityTypeFactory
    ) {
        $this->validator = $validator;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->entityTypeFactory = $entityTypeFactory;
    }

    /**
     * Validate entity type object
     *
     * @param EntityType $value
     *
     * @return bool
     */
    public function isValid($value): bool
    {
        $object = $this->entityTypeFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $object,
            $value->getData(),
            EntityTypeInterface::class
        );

        $this->validationResult = $this->validator->validate($object);

        return  $this->validationResult->isValid();
    }

    public function getMessages(): array
    {
        return $this->validationResult->getErrors();
    }
}
