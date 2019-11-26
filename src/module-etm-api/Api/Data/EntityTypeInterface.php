<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_Etm
 * @package   Ainnomix\EtmApi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmApi\Api\Data;

/**
 * Entity type model interface
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmApi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
interface EntityTypeInterface
{

    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_TYPE_ID = 'entity_type_id';
    const ENTITY_TYPE_CODE = 'entity_type_code';
    const ENTITY_TYPE_NAME = 'entity_type_name';
    const ENTITY_MODEL = 'entity_model';
    const ATTRIBUTE_MODEL = 'attribute_model';
    const ENTITY_TABLE = 'entity_table';
    const VALUE_TABLE_PREFIX = 'value_table_prefix';
    const ENTITY_ID_FIELD = 'entity_id_field';
    const IS_DATA_SHARING = 'is_data_sharing';
    const DATA_SHARING_KEY = 'data_sharing_key';
    const DEFAULT_ATTRIBUTE_SET_ID = 'default_attribute_set_id';
    const INCREMENT_MODEL = 'increment_model';
    const INCREMENT_PER_STORE = 'increment_per_store';
    const INCREMENT_PAD_LENGTH = 'increment_pad_length';
    const INCREMENT_PAD_CHAR = 'increment_pad_char';
    const ADDITIONAL_ATTRIBUTE_TABLE = 'additional_attribute_table';
    const ENTITY_ATTRIBUTE_COLLECTION = 'entity_attribute_collection';
    /**#@-*/

    public function getEntityTypeId(): ?int;

    public function setEntityTypeId(int $typeId): void;

    public function getEntityTypeCode(): ?string;

    public function setEntityTypeCode(string $code): void;

    public function getEntityModel(): ?string;

    public function setEntityModel(string $name): void;

    public function getAttributeModel(): ?string;

    public function setAttributeModel(string $model): void;

    public function getEntityTable(): ?string;

    public function setEntityTable(string $name): void;

    public function getValueTablePrefix(): ?string;

    public function setValueTablePrefix(string $prefix): void;

    public function getEntityIdField(): ?string;

    public function setEntityIdField(string $name): void;

    public function getIsDataSharing(): ?int;

    public function setIsDataSharing(int $flag): void;

    public function getDataSharingKey(): ?string;

    public function setDataSharingKey(string $key): void;

    public function getDefaultAttributeDetId(): ?int;

    public function setDefaultAttributeDetId(int $attributeSetId): void;

    public function getIncrementModel(): ?string;

    public function setIncrementModel(string $modelName): void;

    public function getIncrementPerStore(): ?int;

    public function setIncrementPerStore(int $flag): void;

    public function getIncrementPadLength(): ?int;

    public function setIncrementPadLength(int $length): void;

    public function getIncrementPadChar(): ?string;

    public function setIncrementPadChar(string $char): void;

    public function getAdditionalAttributeTable(): ?string;

    public function setAdditionalAttributeTable(string $tableName): void;

    public function getEntityAttributeCollection(): ?string;

    public function setEntityAttributeCollection(string $modelName): void;

    public function getEntityTypeName(): ?string;

    public function setEntityTypeName(string $name): void;

    public function getExtensionAttributes(): \Ainnomix\EtmApi\Api\Data\EntityTypeExtensionInterface;

    public function setExtensionAttributes(\Ainnomix\EtmApi\Api\Data\EntityTypeExtensionInterface $extensionAttributes): EntityTypeInterface;
}
