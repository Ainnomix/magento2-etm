<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType;

use Magento\Framework\Validator\DataObject;
use Magento\Framework\Validator\DataObjectFactory;

class ValidatorFactory
{

    /**
     * @var DataObjectFactory
     */
    private $validatorFactory;

    /**
     * @var ValidationRules
     */
    private $validationRules;

    public function __construct(DataObjectFactory $validatorFactory, ValidationRules $validationRules)
    {
        $this->validatorFactory = $validatorFactory;
        $this->validationRules = $validationRules;
    }

    public function create(): DataObject
    {
        $validator = $this->validatorFactory->create();
        $this->validationRules->addValidationRules($validator);

        return $validator;
    }
}
