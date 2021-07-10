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

use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface AttributeSetRepositoryInterface
{

    /**
     * Get attribute set by given id
     *
     * @param int $setId
     *
     * @return AttributeSetInterface
     *
     * @throws NoSuchEntityException
     */
    public function get(int $setId): AttributeSetInterface;

    /**
     * Save attribute set data
     *
     * @param AttributeSetInterface $attributeSet
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function save(AttributeSetInterface $attributeSet): int;

    /**
     * Delete attribute set by ID. If entity does not exist do nothing
     *
     * @param int $setId Attribute set ID
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $setId): void;

    /**
     * Find attribute sets by given SearchCriteria
     * SearchCriteria is not required because load all types is useful case
     *
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return AttributeSetSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria = null): AttributeSetSearchResultsInterface;
}
