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

namespace Ainnomix\EtmCore\Model\ResourceModel\Entity;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\ResourceModel\Entity;
use Ainnomix\EtmCore\Model\ResourceModel\EntityFactory;
use InvalidArgumentException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class ResourceRegistry
{

    /**
     * @var Entity[]
     */
    protected $resources = [];

    /**
     * Class dependencies
     *
     * @param EntityFactory $resourceFactory
     */
    public function __construct(
        protected EntityFactory $resourceFactory
    ) {
    }

    /**
     * Retrieve proper entity resource model
     *
     * @param EntityTypeInterface|string $entityType
     * @param array $data
     *
     * @return Entity
     *
     * @throws NoSuchEntityException|LocalizedException|InvalidArgumentException
     */
    public function getOrCreate(EntityTypeInterface|string $entityType, array $data = []): Entity
    {
        if (!($entityType instanceof EntityTypeInterface) && !is_string($entityType)) {
            throw new InvalidArgumentException(
                sprintf('Entity type must extend %s or string', EntityTypeInterface::class)
            );
        }

        $code = is_string($entityType) ? $entityType : $entityType->getEntityTypeCode();
        if (!array_key_exists($code, $this->resources)) {
            $this->resources[$code] = $this->resourceFactory->create($entityType, $data);
        }

        return $this->resources[$code];
    }
}
