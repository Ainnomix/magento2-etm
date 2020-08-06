<?php
/*
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

namespace Ainnomix\EtmCore\Api;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Entity type repository interface
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 * @author   Roman Tomchak <roman@ainnomix.com>
 */
interface EntityTypeRepositoryInterface
{

    /**
     * Get Entity type by given entityTypeCode
     *
     * @param string $entityTypeCode
     *
     * @return EntityTypeInterface
     *
     * @throws NoSuchEntityException
     */
    public function get(string $entityTypeCode): EntityTypeInterface;

    /**
     * Get Entity type by given entityTypeId
     *
     * @param int $entityTypeId
     *
     * @return EntityTypeInterface
     *
     * @throws NoSuchEntityException
     */
    public function getById(int $entityTypeId): EntityTypeInterface;

    /**
     * Save Entity type data
     *
     * @param EntityTypeInterface $entityType
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function save(EntityTypeInterface $entityType): int;

    /**
     * Delete entity type by ID. If entity does not exist do nothing
     *
     * @param int $entityTypeId Entity type ID
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $entityTypeId): void;

    /**
     * Find Entity types by given SearchCriteria
     * SearchCriteria is not required because load all types is useful case
     *
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return EntityTypeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria = null): EntityTypeSearchResultsInterface;
}
