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

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntityInterfaceFactory;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\ResourceRegistry;
use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class GetById implements GetByIdInterface
{

    /**
     * Class dependencies
     *
     * @param EntityInterfaceFactory $entityFactory
     * @param ResourceRegistry $resourceRegistry
     */
    public function __construct(
        protected EntityInterfaceFactory $entityFactory,
        protected ResourceRegistry $resourceRegistry
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(string $typeCode, int $entityId): EntityInterface
    {
        $entity = $this->entityFactory->create();
        try {
            $resource = $this->resourceRegistry->getOrCreate($typeCode);
            $resource->load($entity, $entityId);
        } catch (Exception $exception) {
            throw new LocalizedException(__($exception->getMessage()), $exception, $exception->getCode());
        }

        if (!$entity->getId()) {
            throw new NoSuchEntityException(__(sprintf('No such entity with ID "%s"', $entityId)));
        }

        return $entity;
    }
}
