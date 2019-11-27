<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Api;

use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface AttributeGroupRepositoryInterface
{

    /**
     * Get attribute group by given id
     *
     * @param int $groupId
     *
     * @return AttributeGroupInterface
     *
     * @throws NoSuchEntityException
     */
    public function get(int $groupId): AttributeGroupInterface;

    /**
     * Save attribute group data
     *
     * @param AttributeGroupInterface $attributeGroup
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function save(AttributeGroupInterface $attributeGroup): int;

    /**
     * Delete attribute group by ID. If entity does not exist do nothing
     *
     * @param int $groupId Attribute group ID
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $groupId): void;

    /**
     * Find attribute group by given SearchCriteria
     * SearchCriteria is not required because load all types is useful case
     *
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return AttributeGroupSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria = null): AttributeGroupSearchResultsInterface;
}
