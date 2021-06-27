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

use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface AttributeRepositoryInterface
{

    /**
     * Save entity attribute
     *
     * @param AttributeInterface $attribute
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function save(AttributeInterface $attribute): int;

    /**
     * Load entity attribute by given type code and attribute code
     *
     * @param string $entityTypeCode
     * @param string $attributeCode
     *
     * @return AttributeInterface
     *
     * @throws NoSuchEntityException
     */
    public function get(string $entityTypeCode, string $attributeCode): AttributeInterface;

    /**
     * Load entity attribute by attribute ID
     *
     * @param int $attributeId
     *
     * @return AttributeInterface
     *
     * @throws NoSuchEntityException
     */
    public function getById(int $attributeId): AttributeInterface;

    /**
     * Delete entity attribute by ID
     *
     * @param int $attributeId
     *
     * @return void
     *
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $attributeId): void;

    /**
     * Retrieve attributes list by given criteria
     *
     * @param SearchCriteriaInterface|null $criteria
     *
     * @return AttributeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria = null): AttributeSearchResultsInterface;
}
