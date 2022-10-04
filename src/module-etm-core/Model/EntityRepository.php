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
use Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface;
use Ainnomix\EtmCore\Api\EntityRepositoryInterface;
use Ainnomix\EtmCore\Model\Entity\Command\DeleteByIdInterface;
use Ainnomix\EtmCore\Model\Entity\Command\GetByIdInterface;
use Ainnomix\EtmCore\Model\Entity\Command\GetListInterface;
use Ainnomix\EtmCore\Model\Entity\Command\SaveInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class EntityRepository implements EntityRepositoryInterface
{

    /**
     * Class dependencies
     *
     * @param GetByIdInterface $commandGetById
     * @param SaveInterface $commandSave
     * @param DeleteByIdInterface $commandDeleteById
     * @param GetListInterface $commandGetList
     */
    public function __construct(
        protected GetByIdInterface $commandGetById,
        protected SaveInterface $commandSave,
        protected DeleteByIdInterface $commandDeleteById,
        protected GetListInterface $commandGetList
    ) {
    }

    /**
     * @inheritDoc
     */
    public function get(string $typeCode, int $entityId): EntityInterface
    {
        return $this->commandGetById->execute($typeCode, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function save(string $typeCode, EntityInterface $entity): EntityInterface
    {
        return $this->commandSave->execute($typeCode, $entity);
    }

    /**
     * @inheritDoc
     */
    public function deleteById(string $typeCode, int $entityId): bool
    {
        return $this->commandDeleteById->execute($typeCode, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getList(string $typeCode, SearchCriteriaInterface $criteria = null): EntitySearchResultsInterface
    {
        return $this->commandGetList->execute($typeCode, $criteria);
    }
}
