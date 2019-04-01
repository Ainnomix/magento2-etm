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

namespace Ainnomix\EtmCore\Model\Entity;

use Ainnomix\EtmApi\Api\Data\EntityTypeInterface;

/**
 * Entity type model class
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmCore
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Type extends \Magento\Eav\Model\Entity\Type implements EntityTypeInterface
{

    /**
     * Configure model
     */
    protected function _construct(): void
    {
        $this->_init(\Ainnomix\EtmCore\Model\ResourceModel\Entity\Type::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeId(): ?int
    {
        return null === parent::getEntityTypeId() ? null : (int) parent::getEntityTypeId();
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityTypeId(int $id): void
    {
        $this->setData(static::ENTITY_TYPE_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeCode(): ?string
    {
        return $this->getData(static::ENTITY_TYPE_CODE);
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityTypeCode(string $code): void
    {
        $this->setData(static::ENTITY_TYPE_CODE, $code);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeName(): ?string
    {
        return $this->getData(static::ENTITY_TYPE_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityTypeName(string $name): void
    {
        $this->setData(static::ENTITY_TYPE_NAME, $name);
    }
}
