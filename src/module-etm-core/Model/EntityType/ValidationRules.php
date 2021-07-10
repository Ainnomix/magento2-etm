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

namespace Ainnomix\EtmCore\Model\EntityType;

use Magento\Framework\Validator\DataObject as Validator;
use Magento\Framework\Validator\NotEmpty;
use Magento\Framework\Validator\Regex;

class ValidationRules
{

    public function addValidationRules(Validator $validator): void
    {
        $nameValidator = new NotEmpty();
        $nameValidator->setMessage(
            __('Entity type name value is required and can\'t be empty'),
            NotEmpty::IS_EMPTY
        );

        $codeValueValidator = new NotEmpty();
        $codeValueValidator->setMessage(
            __('Entity type code value is required and can\'t be empty'),
            NotEmpty::IS_EMPTY
        );

        $codeFormatValidator = new Regex('/^[a-z0-9]{1}[a-z0-9_]+$/');
        $codeFormatValidator->setMessage(
            __('Entity type code does not match against pattern "/^[a-z0-9]{1}[a-z0-9_]+$/"')
        );

        $validator->addRule($nameValidator, 'entity_type_name');
        $validator->addRule($codeValueValidator, 'entity_type_code');
        $validator->addRule($codeFormatValidator, 'entity_type_code');
    }
}
