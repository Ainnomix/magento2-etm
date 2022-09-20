<?php
/**
 * This file is part of the Ainnomix Entity Type Manager package.
 *
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2022 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Ainnomix\EtmCore\Api\Data;

interface EntityTypeInterface
{
    /**
     * String constants for property names
     */
    public const ENTITY_TYPE_ID = "entity_type_id";
    public const ENTITY_TYPE_CODE = "entity_type_code";
    public const ENTITY_TYPE_NAME = "entity_type_name";
    public const DEFAULT_ATTRIBUTE_SET_ID = "default_attribute_set_id";

    /**
     * Get entity type ID.
     *
     * @return int|null
     */
    public function getEntityTypeId(): ?int;

    /**
     * Set value of entity type ID.
     *
     * @param int $entityTypeId
     *
     * @return self
     */
    public function setEntityTypeId(int $entityTypeId): self;

    /**
     * Get entity type code.
     *
     * @return string|null
     */
    public function getEntityTypeCode(): ?string;

    /**
     * Set value of entity type code.
     *
     * @param string $entityTypeCode
     *
     * @return self
     */
    public function setEntityTypeCode(string $entityTypeCode): self;

    /**
     * Get entity type name.
     *
     * @return string|null
     */
    public function getEntityTypeName(): ?string;

    /**
     * Set value of entity type name.
     *
     * @param string $entityTypeName
     *
     * @return self
     */
    public function setEntityTypeName(string $entityTypeName): self;

    /**
     * Get default attribute set ID.
     *
     * @return int|null
     */
    public function getDefaultAttributeSetId(): ?int;

    /**
     * Set value of entity type name.
     *
     * @param int $attributeSetId
     *
     * @return self
     */
    public function setDefaultAttributeSetId(int $attributeSetId): self;
}
