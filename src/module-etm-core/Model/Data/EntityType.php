<?php
/*
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

namespace Ainnomix\EtmCore\Model\Data;

use Magento\Framework\Api\AbstractSimpleObject;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

/**
 * Entity Type data model
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class EntityType extends AbstractSimpleObject implements EntityTypeInterface
{

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeId(): ?int
    {
        return $this->_get(self::ENTITY_TYPE_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityTypeId(int $typeId): void
    {
        $this->setData(self::ENTITY_TYPE_ID, $typeId);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeCode(): ?string
    {
        return $this->_get(self::ENTITY_TYPE_CODE);
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityTypeCode(string $code): void
    {
        $this->setData(self::ENTITY_TYPE_CODE, $code);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeName(): ?string
    {
        return $this->_get(self::ENTITY_TYPE_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityTypeName(string $name): void
    {
        $this->setData(self::ENTITY_TYPE_NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
//    public function getEntityModel(): ?string
//    {
//        return $this->_get(self::ENTITY_MODEL);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setEntityModel(string $name): void
//    {
//        $this->setData(self::ENTITY_MODEL, $name);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getAttributeModel(): ?string
//    {
//        return $this->_get(self::ATTRIBUTE_MODEL);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setAttributeModel(string $model): void
//    {
//        $this->setData(self::ATTRIBUTE_MODEL, $model);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getEntityTable(): ?string
//    {
//        return $this->_get(self::ENTITY_TABLE);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setEntityTable(string $name): void
//    {
//        $this->setData(self::ENTITY_TABLE, $name);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getValueTablePrefix(): ?string
//    {
//        return $this->_get(self::VALUE_TABLE_PREFIX);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setValueTablePrefix(string $prefix): void
//    {
//        $this->setData(self::VALUE_TABLE_PREFIX, $prefix);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getEntityIdField(): ?string
//    {
//        return $this->_get(self::ENTITY_ID_FIELD);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setEntityIdField(string $name): void
//    {
//        $this->setData(self::ENTITY_ID_FIELD, $name);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getIsDataSharing(): ?int
//    {
//        return $this->_get(self::IS_DATA_SHARING);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setIsDataSharing(int $flag): void
//    {
//        $this->setData(self::IS_DATA_SHARING, $flag);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getDataSharingKey(): ?string
//    {
//        return $this->_get(self::DATA_SHARING_KEY);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setDataSharingKey(string $key): void
//    {
//        $this->setData(self::DATA_SHARING_KEY, $key);
//    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultAttributeSetId(): ?int
    {
        return $this->_get(self::DEFAULT_ATTRIBUTE_SET_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultAttributeSetId(int $attributeSetId): void
    {
        $this->setData(self::DEFAULT_ATTRIBUTE_SET_ID, $attributeSetId);
    }

    /**
     * {@inheritDoc}
     */
//    public function getIncrementModel(): ?string
//    {
//        return $this->_get(self::INCREMENT_MODEL);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setIncrementModel(string $modelName): void
//    {
//        $this->setData(self::INCREMENT_MODEL, $modelName);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getIncrementPerStore(): ?int
//    {
//        return $this->_get(self::INCREMENT_PER_STORE);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setIncrementPerStore(int $flag): void
//    {
//        $this->setData(self::INCREMENT_PER_STORE, $flag);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getIncrementPadLength(): ?int
//    {
//        return $this->_get(self::INCREMENT_PAD_LENGTH);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setIncrementPadLength(int $length): void
//    {
//        $this->setData(self::INCREMENT_PAD_LENGTH, $length);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getIncrementPadChar(): ?string
//    {
//        return $this->_get(self::INCREMENT_PAD_CHAR);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setIncrementPadChar(string $char): void
//    {
//        $this->setData(self::INCREMENT_PAD_CHAR, $char);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getAdditionalAttributeTable(): ?string
//    {
//        return $this->_get(self::ADDITIONAL_ATTRIBUTE_TABLE);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setAdditionalAttributeTable(string $tableName): void
//    {
//        $this->setData(self::ADDITIONAL_ATTRIBUTE_TABLE, $tableName);
//    }

    /**
     * {@inheritDoc}
     */
//    public function getEntityAttributeCollection(): ?string
//    {
//        return $this->_get(self::ENTITY_ATTRIBUTE_COLLECTION);
//    }

    /**
     * {@inheritDoc}
     */
//    public function setEntityAttributeCollection(string $modelName): void
//    {
//        $this->setData(self::ENTITY_ATTRIBUTE_COLLECTION, $modelName);
//    }

    /**
     * Get object data by key with calling getter method
     *
     * @param string $key
     * @param mixed $args
     *
     * @return mixed
     */
//    public function getDataUsingMethod($key, $args = null)
//    {
//        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
//        return $this->{$method}($args);
//    }
}
