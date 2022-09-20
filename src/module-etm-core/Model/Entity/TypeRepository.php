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
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmCore\Model\Entity\Type\Command\DeleteByIdInterface;
use Ainnomix\EtmCore\Model\Entity\Type\Command\GetByIdInterface;
use Ainnomix\EtmCore\Model\Entity\Type\Command\GetInterface;
use Ainnomix\EtmCore\Model\Entity\Type\Command\GetListInterface;
use Ainnomix\EtmCore\Model\Entity\Type\Command\SaveInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class TypeRepository implements EntityTypeRepositoryInterface
{

    /**
     * @var GetInterface
     */
    protected GetInterface $commandGet;

    /**
     * @var GetByIdInterface
     */
    protected GetByIdInterface $commandGetById;

    /**
     * @var SaveInterface
     */
    protected SaveInterface $commandSave;

    /**
     * @var DeleteByIdInterface
     */
    protected DeleteByIdInterface $commandDeleteById;

    /**
     * @var GetListInterface
     */
    protected GetListInterface $commandGetList;

    /**
     * Repository dependencies configuration
     *
     * @param GetInterface $commandGet
     * @param GetByIdInterface $commandGetById
     * @param SaveInterface $commandSave
     * @param DeleteByIdInterface $commandDeleteById
     * @param GetListInterface $commandGetList
     */
    public function __construct(
        GetInterface $commandGet,
        GetByIdInterface $commandGetById,
        SaveInterface $commandSave,
        DeleteByIdInterface $commandDeleteById,
        GetListInterface $commandGetList
    ) {
        $this->commandGet = $commandGet;
        $this->commandGetById = $commandGetById;
        $this->commandSave = $commandSave;
        $this->commandDeleteById = $commandDeleteById;
        $this->commandGetList = $commandGetList;
    }

    /**
     * @inheritDoc
     */
    public function get(string $typeCode): EntityTypeInterface
    {
        return $this->commandGet->execute($typeCode);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $typeId): EntityTypeInterface
    {
        return $this->commandGetById->execute($typeId);
    }

    /**
     * @inheritDoc
     */
    public function save(EntityTypeInterface $entityType): EntityTypeInterface
    {
        return $this->commandSave->execute($entityType);
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $typeId): bool
    {
        return $this->commandDeleteById->execute($typeId);
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $criteria = null): EntityTypeSearchResultsInterface
    {
        return $this->commandGetList->execute($criteria);
    }
}
