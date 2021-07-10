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

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Magento\Eav\Model\ResourceModel\Entity\Type as EavEntityType;
use Zend_Validate_Callback;

/**
 * Entity type resource model class
 *
 * @author Roman Tomchak <romantomchak@gmail.com>
 */
class EntityType extends EavEntityType
{

    /**
     * Add validation rules to be applied before saving an entity
     *
     * @return Zend_Validate_Callback $validator
     */
    public function getValidationRulesBeforeSave()
    {
        $entityTypeIdentity = new Zend_Validate_Callback([$this, 'isEntityTypeUnique']);
        $entityTypeIdentity->setMessage(
            __('Entity type with the same code already exists.'),
            Zend_Validate_Callback::INVALID_VALUE
        );

        return $entityTypeIdentity;
    }

    public function isEntityTypeUnique(\Magento\Framework\Model\AbstractModel $model): bool
    {
        $connection = $this->getConnection();
        $select = $connection->select();

        $binds = ['entity_type_code' => $model->getEntityTypeCode()];

        $select->from($this->getMainTable())
            ->where('entity_type_code = :entity_type_code');

        if ($model->getEntityTypeId()) {
            $binds['entity_type_id'] = $model->getEntityTypeId();

            $select->where('entity_type_id != :entity_type_id');
        }

        $row = $connection->fetchRow($select, $binds);

        return empty($row);
    }

    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        $select->where('is_custom = ?', 1);

        return $select;
    }
}
