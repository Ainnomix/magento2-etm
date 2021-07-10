<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Api;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface EntityRepositoryInterface
{

    /**
     * Get entity by given entityId
     *
     * @param EntityTypeInterface $entityType
     * @param int $entityId
     *
     * @return EntityInterface
     *
     * @throws NoSuchEntityException
     */
    public function getById(EntityTypeInterface $entityType, int $entityId): EntityInterface;

    /**
     * Save entity data
     *
     * @param EntityTypeInterface $entityType
     * @param EntityInterface $entity
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function save(EntityTypeInterface $entityType, EntityInterface $entity): int;

    /**
     * Delete entity by ID
     *
     * @param EntityTypeInterface $entityType
     * @param int $entityId
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(EntityTypeInterface $entityType, int $entityId): void;

    /**
     * Find entities by given SearchCriteria
     *
     * @param EntityTypeInterface $entityType
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return EntitySearchResultsInterface
     */
    public function getList(EntityTypeInterface $entityType, SearchCriteriaInterface $criteria = null): EntitySearchResultsInterface;
}
