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

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Entity extends AbstractExtensibleModel implements EntityInterface
{

    /**
     * Initialize resource mode
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Entity::class);
    }

    /**
     * @inheritDoc
     */
    public function setId($entityId): self
    {
        return parent::setId((int) $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        $value = parent::getId();
        return null !== $value ? (int) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function getAttributeSetId(): int
    {
        return (int) $this->getData(static::KEY_ATTRIBUTE_SET_ID);
    }

    /**
     * @inheritDoc
     */
    public function setAttributeSetId(int $setId): EntityInterface
    {
        return $this->setData(static::KEY_ATTRIBUTE_SET_ID, $setId);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(static::KEY_CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(static::KEY_UPDATED_AT);
    }
}
