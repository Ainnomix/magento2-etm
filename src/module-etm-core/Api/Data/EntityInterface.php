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

use Magento\Eav\Model\Entity\EntityInterface as EavEntityInterface;
use Magento\Framework\Api\CustomAttributesDataInterface;

interface EntityInterface extends EavEntityInterface, CustomAttributesDataInterface
{

    /**#@+
     * Constants defined for keys of data array
     */
    public const KEY_ATTRIBUTE_SET_ID = 'attribute_set_id';
    public const KEY_UPDATED_AT = 'updated_at';
    public const KEY_CREATED_AT = 'created_at';

    /**
     * Get entity ID
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set entity ID value
     *
     * @param int $entityId
     *
     * @return self
     */
    public function setId($entityId): self;

    /**
     * Get entity attribute set ID
     *
     * @return int
     */
    public function getAttributeSetId(): int;

    /**
     * Set entity attribute set ID
     *
     * @param int $setId
     *
     * @return self
     */
    public function setAttributeSetId(int $setId): self;

    /**
     * Retrieve entity creation date and time.
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Retrieve entity last update date and time.
     *
     * @return string
     */
    public function getUpdatedAt(): string;
}
