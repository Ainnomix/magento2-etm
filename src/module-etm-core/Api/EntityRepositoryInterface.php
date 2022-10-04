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

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Entity type repository interface.
 * Provides CRUD operation for entity types.
 */
interface EntityRepositoryInterface
{

    /**
     * Get Entity by given ID
     *
     * @param string $typeCode Entity type code
     * @param int $entityId Entity ID
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get(string $typeCode, int $entityId): EntityInterface;

    /**
     * Save Entity data
     *
     * @param string $typeCode Entity type code
     * @param EntityInterface $entity Entity instance
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntityInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(string $typeCode, EntityInterface $entity): EntityInterface;

    /**
     * Delete entity by ID
     *
     * @param string $typeCode Entity type code
     * @param int $entityId Entity ID
     *
     * @return bool true on success
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(string $typeCode, int $entityId): bool;

    /**
     * Find Entity by given SearchCriteria
     *
     * @param string $typeCode
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $criteria
     *
     * @return \Ainnomix\EtmCore\Api\Data\EntitySearchResultsInterface
     *
     * @throw \Magento\Framework\Exception\LocalizedException
     */
    public function getList(string $typeCode, SearchCriteriaInterface $criteria = null): EntitySearchResultsInterface;
}
