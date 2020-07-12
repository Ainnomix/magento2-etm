<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmCore\Model\EntityType\Command;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Entity type model repository class
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmCore
 * @author   Roman Tomchak <roman@ainnomix.com>
 */
class EntityTypeRepository implements EntityTypeRepositoryInterface
{

    /**
     * @var Command\GetInterface
     */
    protected $commandGet;

    /**
     * @var Command\GetByIdInterface
     */
    protected $commandGetById;

    /**
     * @var Command\GetListInterface
     */
    protected $commandGetList;

    /**
     * @var Command\SaveInterface
     */
    protected $commandSave;

    /**
     * @var Command\DeleteByIdInterface
     */
    protected $commandDeleteById;

    /**
     * TypeRepository constructor
     *
     * @param Command\GetInterface $commandGet
     * @param Command\GetByIdInterface $commandGetById
     * @param Command\GetListInterface $commandGetList
     * @param Command\SaveInterface $commandSave
     * @param Command\DeleteByIdInterface $commandDeleteById
     */
    public function __construct(
        Command\GetInterface $commandGet,
        Command\GetByIdInterface $commandGetById,
        Command\GetListInterface $commandGetList,
        Command\SaveInterface $commandSave,
        Command\DeleteByIdInterface $commandDeleteById
    ) {
        $this->commandGet = $commandGet;
        $this->commandGetById = $commandGetById;
        $this->commandGetList = $commandGetList;
        $this->commandSave = $commandSave;
        $this->commandDeleteById = $commandDeleteById;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $entityTypeCode): EntityTypeInterface
    {
        return $this->commandGet->execute($entityTypeCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $entityTypeId): EntityTypeInterface
    {
        return $this->commandGetById->execute($entityTypeId);
    }

    /**
     * {@inheritDoc}
     */
    public function save(EntityTypeInterface $entityType): int
    {
        return $this->commandSave->execute($entityType);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $entityTypeId): void
    {
        $this->commandDeleteById->execute($entityTypeId);
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria = null): EntityTypeSearchResultsInterface
    {
        return $this->commandGetList->execute($criteria);
    }
}
