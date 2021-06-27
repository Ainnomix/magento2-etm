<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\EntityRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Ainnomix\EtmCore\Model\Entity\Command;

class EntityRepository implements EntityRepositoryInterface
{

    /**
     * @var Command\GetByIdInterface
     */
    protected $commandGetById;

    /**
     * @var Command\SaveInterface
     */
    protected $commandSave;

    /**
     * @var Command\DeleteByIdInterface
     */
    protected $commandDeleteById;

    /**
     * @var Command\GetListInterface
     */
    protected $commandGetList;

    public function __construct(
        Command\GetByIdInterface $commandGetById,
        Command\SaveInterface $commandSave,
        Command\DeleteByIdInterface $commandDeleteById,
        Command\GetListInterface $commandGetList
    ) {
        $this->commandGetById = $commandGetById;
        $this->commandSave = $commandSave;
        $this->commandDeleteById = $commandDeleteById;
        $this->commandGetList = $commandGetList;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(EntityTypeInterface $entityType, int $entityId): EntityInterface
    {
        return $this->commandGetById->execute($entityType, $entityId);
    }

    /**
     * {@inheritDoc}
     */
    public function save(EntityTypeInterface $entityType, EntityInterface $entity): int
    {
        return $this->commandSave->execute($entityType, $entity);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(EntityTypeInterface $entityType, int $entityId): void
    {
        $this->commandDeleteById->execute($entityType, $entityId);
    }

    /**
     * {@inheritDoc}
     */
    public function getList(EntityTypeInterface $entityType, SearchCriteriaInterface $criteria = null): EntitySearchResultsInterface
    {
        return $this->commandGetList->execute($entityType, $criteria);
    }
}
