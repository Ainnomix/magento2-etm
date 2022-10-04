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

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\Entity\TypeManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validator\UniversalFactory;

class EntityFactory
{

    /**
     * Class dependencies
     *
     * @param UniversalFactory $universalFactory
     * @param TypeManager $typeManager
     */
    public function __construct(
        protected UniversalFactory $universalFactory,
        protected TypeManager $typeManager
    ) {
    }

    /**
     * Create entity type resource model
     *
     * @param EntityTypeInterface|string $entityType
     * @param array $data
     *
     * @return Entity
     *
     * @throws NoSuchEntityException|LocalizedException
     */
    public function create(EntityTypeInterface|string $entityType, array $data = []): Entity
    {
        $typeInstance = $this->typeManager->getEntityType($entityType);

        $resource = $this->universalFactory->create(Entity::class, $data);
        $resource->setType($typeInstance);

        return $resource;
    }
}
