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

namespace Ainnomix\EtmCore\Test\Integration\Model;

use Ainnomix\EtmCore\Api\AttributeGroupRepositoryInterface;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterfaceFactory;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Magento\Eav\Model\Config;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\TestFramework\Helper\Bootstrap;

trait EntityTypeHelperTrait
{

    public static function getEntityType(): EntityTypeInterface
    {
        /** @var EntityTypeRepositoryInterface $entityTypeRepository */
        $entityTypeRepository = Bootstrap::getObjectManager()->get(EntityTypeRepositoryInterface::class);

        try {
            $entityType = $entityTypeRepository->get('entity_type_test');
        } catch (NoSuchEntityException $exception) {
            /** @var EntityTypeInterfaceFactory $entityTypeFactory */
            $entityTypeFactory = Bootstrap::getObjectManager()->get(EntityTypeInterfaceFactory::class);

            $entityType = $entityTypeFactory->create();
            $entityType->setEntityTypeCode('entity_type_test');
            $entityType->setEntityTypeName('entity_type_test');

            $entityTypeId = $entityTypeRepository->save($entityType);
            $entityType->setEntityTypeId($entityTypeId);

            Bootstrap::getObjectManager()->get(Config::class)->clear();
        }

        return $entityType;
    }

    public static function getAttributeSet(EntityTypeInterface $entityType): AttributeSetInterface
    {
        /** @var AttributeSetRepositoryInterface $attributeSetRepository */
        $attributeSetRepository = Bootstrap::getObjectManager()->get(AttributeSetRepositoryInterface::class);

        /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
        $searchCriteriaBuilder = Bootstrap::getObjectManager()->get(SearchCriteriaBuilder::class);
        $searchCriteriaBuilder->addFilter('entity_type_id', $entityType->getEntityTypeId(), 'eq');
        $searchCriteriaBuilder->addFilter('attribute_set_name', 'attribute_set_test', 'eq');
        $searchCriteria = $searchCriteriaBuilder->create();

        $searchResult = $attributeSetRepository->getList($searchCriteria);

        if ((int) $searchResult->getTotalCount() > 0) {
            $attributeSet = current($searchResult->getItems());
        }
        if ((int) $searchResult->getTotalCount() === 0) {
            /** @var AttributeSetInterfaceFactory $attributeSetFactory */
            $attributeSetFactory = Bootstrap::getObjectManager()->get(AttributeSetInterfaceFactory::class);

            $attributeSet = $attributeSetFactory->create();
            $attributeSet->setEntityTypeId((int) $entityType->getEntityTypeId());
            $attributeSet->setAttributeSetName('attribute_set_test');
            $attributeSet->setSortOrder('100');

            $attributeSetId = $attributeSetRepository->save($attributeSet);
            $attributeSet->setAttributeSetId($attributeSetId);
        }

        return $attributeSet;
    }

    public static function getAttributeGroup(AttributeSetInterface $attributeSet): AttributeGroupInterface
    {
        /** @var AttributeGroupRepositoryInterface $attributeGroupRepository */
        $attributeGroupRepository = Bootstrap::getObjectManager()->get(AttributeGroupRepositoryInterface::class);

        /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
        $searchCriteriaBuilder = Bootstrap::getObjectManager()->get(SearchCriteriaBuilder::class);
        $searchCriteriaBuilder->addFilter('attribute_set_id', $attributeSet->getAttributeSetId(), 'eq');
        $searchCriteriaBuilder->addFilter('attribute_group_name', 'attribute_group_test', 'eq');
        $searchCriteria = $searchCriteriaBuilder->create();

        $searchResult = $attributeGroupRepository->getList($searchCriteria);

        if ((int) $searchResult->getTotalCount() > 0) {
            $attributeGroup = current($searchResult->getItems());
        }
        if ((int) $searchResult->getTotalCount() === 0) {
            /** @var AttributeGroupInterfaceFactory $attributeGroupFactory */
            $attributeGroupFactory = Bootstrap::getObjectManager()->get(AttributeGroupInterfaceFactory::class);

            $attributeGroup = $attributeGroupFactory->create();
            $attributeGroup->setAttributeSetId((int) $attributeSet->getAttributeSetId());
            $attributeGroup->setAttributeGroupName('attribute_group_test');

            $attributeGroupId = $attributeGroupRepository->save($attributeGroup);
            $attributeGroup->setAttributeGroupId($attributeGroupId);
        }

        return $attributeGroup;
    }
}
