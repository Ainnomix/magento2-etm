<?php

namespace Ainnomix\EtmCore\Model\Entity;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

class Type extends \Magento\Eav\Model\Entity\Type implements EntityTypeInterface
{

    protected function _construct()
    {
        $this->_init(\Ainnomix\EtmCore\Model\ResourceModel\Entity\Type::class);
    }

    public function setEntityTypeId(int $value): EntityTypeInterface
    {
        return $this->setData('entity_type_id', $value);
    }

    public function setEntityTypeCode(string $value): EntityTypeInterface
    {
        return $this->setData('entity_type_code', $value);
    }

    public function getEntityModel()
    {
        return $this->getData('entity_model');
    }

    public function setEntityModel(string $value): EntityTypeInterface
    {
        return $this->setData('entity_model', $value);
    }

    public function setAttributeModel(string $value): EntityTypeInterface
    {
        return $this->setData('attribute_model', $value);
    }

    public function setEntityTable(string $value): EntityTypeInterface
    {
        return $this->setData('entity_table', $value);
    }

    public function setValueTablePrefix(string $value): EntityTypeInterface
    {
        return $this->setData('value_table_prefix', $value);
    }

    public function setEntityIdField(string $value): EntityTypeInterface
    {
        return $this->setData('entity_id_field', $value);
    }

    public function getIsDataSharing()
    {
        return $this->getData('is_data_sharing');
    }

    public function setIsDataSharing(int $value): EntityTypeInterface
    {
        return $this->setData('is_data_sharing', $value);
    }

    public function getDataSharingKey()
    {
        return $this->getData('data_sharing_key');
    }

    public function setDataSharingKey(string $value): EntityTypeInterface
    {
        return $this->setData('data_sharing_key', $value);
    }

    public function setDefaultAttributeSetId(int $value): EntityTypeInterface
    {
        return $this->setData('default_attribute_set_id', $value);
    }

    public function getIncrementModel()
    {
        return $this->getData('increment_model');
    }

    public function setIncrementModel(string $value): EntityTypeInterface
    {
        return $this->setData('increment_model', $value);
    }

    public function getIncrementPerStore()
    {
        return $this->getData('increment_per_store');
    }

    public function setIncrementPerStore(int $value): EntityTypeInterface
    {
        return $this->setData('increment_per_store', $value);
    }

    public function getIncrementPadLength()
    {
        return $this->getData('increment_pad_length');
    }

    public function setIncrementPadLength(int $value): EntityTypeInterface
    {
        return $this->setData('increment_pad_length', $value);
    }

    public function getIncrementPadChar()
    {
        return $this->getData('increment_pad_char');
    }

    public function setIncrementPadChar(string $value): EntityTypeInterface
    {
        return $this->setData('increment_pad_char', $value);
    }

    public function getAdditionalAttributeTable()
    {
        return $this->getData('additional_attribute_table');
    }

    public function setAdditionalAttributeTable(string $value): EntityTypeInterface
    {
        return $this->setData('additional_attribute_table', $value);
    }

    public function setEntityAttributeCollection(string $value): EntityTypeInterface
    {
        return $this->setData('entity_attribute_collection', $value);
    }
}
