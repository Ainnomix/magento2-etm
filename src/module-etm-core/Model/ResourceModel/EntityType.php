<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_Etm
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Magento\Eav\Model\ResourceModel\Entity\Type as EavEntityType;

/**
 * Entity type resource model class
 *
 * @category Ainnomix
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class EntityType extends EavEntityType
{

    public function getValidationRulesBeforeSave(): \Zend_Validate
    {
        $validator = new \Zend_Validate();

        $codeValidator = new \Zend_Validate_Callback([$this, 'isCodeUnique']);
        $codeValidator->setMessage(
            __('Entity type with the same code already exists.'),
            \Zend_Validate_Callback::INVALID_VALUE
        );
        $validator->addValidator($codeValidator, true);

        return $validator;
    }

    public function isCodeUnique(\Ainnomix\EtmCore\Model\EntityType\Type $entityType)
    {
        if (!$entityType->getEntityTypeId()) {
            $connection = $this->getConnection();
            $select = $connection->select();

            $binds = [
                'entity_type_code' => $entityType->getEntityTypeCode(),
            ];

            $select->from(
                $this->getMainTable()
            )->where(
                '(entity_type_code = :entity_type_code)'
            );

            $row = $connection->fetchRow($select, $binds);

            return empty($row);
        }

        return true;
    }
}
