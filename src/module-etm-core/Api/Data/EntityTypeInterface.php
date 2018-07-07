<?php

namespace Ainnomix\EtmCore\Api\Data;

interface EntityTypeInterface
{

    public function getEntityTypeId();

    public function setEntityTypeId(int $value): EntityTypeInterface;

    public function getEntityTypeCode();

    public function setEntityTypeCode(string $code): EntityTypeInterface;

    public function getEntityModel();

    public function setEntityModel(string $value): EntityTypeInterface;

    public function getAttributeModel();

    public function setAttributeModel(string $value): EntityTypeInterface;

    public function getEntityTable();

    public function setEntityTable(string $value): EntityTypeInterface;

    public function getValueTablePrefix();

    public function setValueTablePrefix(string $value): EntityTypeInterface;

    public function getEntityIdField();

    public function setEntityIdField(string $value): EntityTypeInterface;

    public function getIsDataSharing();

    public function setIsDataSharing(int $value): EntityTypeInterface;

    public function getDataSharingKey();

    public function setDataSharingKey(string $value): EntityTypeInterface;

    public function getDefaultAttributeSetId();

    public function setDefaultAttributeSetId(int $value): EntityTypeInterface;

    public function getIncrementModel();

    public function setIncrementModel(string $value): EntityTypeInterface;

    public function getIncrementPerStore();

    public function setIncrementPerStore(int $value): EntityTypeInterface;

    public function getIncrementPadLength();

    public function setIncrementPadLength(int $value): EntityTypeInterface;

    public function getIncrementPadChar();

    public function setIncrementPadChar(string $value): EntityTypeInterface;

    public function getAdditionalAttributeTable();

    public function setAdditionalAttributeTable(string $value): EntityTypeInterface;

    public function getEntityAttributeCollection();

    public function setEntityAttributeCollection(string $value): EntityTypeInterface;
}
