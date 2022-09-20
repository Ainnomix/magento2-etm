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

namespace Ainnomix\EtmCore\Api;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;

/**
 * Entity type repository interface.
 * Provides CRUD operation for entity types.
 */
interface EntityTypeRepositoryInterface
{

    /**
     * Get Entity type by given entityTypeCode
     *
     * @param string $typeCode
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityTypeInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get(string $typeCode): EntityTypeInterface;

    /**
     * Get Entity type by given entityTypeId
     *
     * @param int $typeId
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityTypeInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $typeId): EntityTypeInterface;

    /**
     * Save Entity type data
     *
     * @param EntityTypeInterface $entityType
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityTypeInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(EntityTypeInterface $entityType): EntityTypeInterface;

    /**
     * Delete entity type by ID
     *
     * @param int $typeId Entity type ID
     *
     * @return bool true on success
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $typeId): bool;

    /**
     * Find Entity types by given SearchCriteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $criteria
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface
     *
     * @throw \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria = null): EntityTypeSearchResultsInterface;
}
