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

namespace Ainnomix\EtmCore\Model\Entity;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Eav\Model\Entity\Type as EavEntityType;

class Type extends EavEntityType implements EntityTypeInterface
{

    /**
     * @inheritDoc
     */
    public function setEntityTypeId(int $entityTypeId): EntityTypeInterface
    {
        return $this->setData(static::ENTITY_TYPE_ID, $entityTypeId);
    }

    /**
     * @inheritDoc
     */
    public function getEntityTypeName(): ?string
    {
        return $this->getData(self::ENTITY_TYPE_NAME) === null ? null
            : (string) $this->getData(self::ENTITY_TYPE_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setEntityTypeName(string $entityTypeName): EntityTypeInterface
    {
        return $this->setData(static::ENTITY_TYPE_NAME, $entityTypeName);
    }
}
