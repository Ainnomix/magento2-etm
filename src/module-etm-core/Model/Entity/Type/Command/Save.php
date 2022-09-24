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

namespace Ainnomix\EtmCore\Model\Entity\Type\Command;

use Ainnomix\EtmCore\Api\AttributeGroupRepositoryInterface;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterfaceFactory;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\TableNameResolver;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Type as Resource;
use Ainnomix\EtmCore\Setup\EntityTypeSetup;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Model\ResourceModel\Db\TransactionManagerInterface;

class Save implements SaveInterface
{

    /**
     * Class dependencies
     *
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param AttributeGroupRepositoryInterface $attributeGroupRepository
     * @param AttributeSetInterfaceFactory $attributeSetFactory
     * @param AttributeGroupInterfaceFactory $attributeGroupFactory
     * @param TransactionManagerInterface $transactionManager
     * @param TableNameResolver $tableNameResolver
     * @param Resource $resource
     * @param EntityTypeSetup $entityTypeSetup
     */
    public function __construct(
        protected AttributeSetRepositoryInterface $attributeSetRepository,
        protected AttributeGroupRepositoryInterface $attributeGroupRepository,
        protected AttributeSetInterfaceFactory $attributeSetFactory,
        protected AttributeGroupInterfaceFactory $attributeGroupFactory,
        protected TransactionManagerInterface $transactionManager,
        protected TableNameResolver $tableNameResolver,
        protected Resource $resource,
        protected EntityTypeSetup $entityTypeSetup
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(EntityTypeInterface $entityType): EntityTypeInterface
    {
        $this->transactionManager->start($this->resource->getConnection());
        $creationFlag = !$entityType->getEntityTypeId();

        try {
            $this->populateDefaultValues($entityType);
            $this->resource->save($entityType);

            if ($creationFlag) {
                $this->createDefaultSetAndGroup($entityType);
            }

            $this->transactionManager->commit();

            if ($creationFlag) {
                $this->entityTypeSetup->createEntityTypeTables($entityType);
            }
        } catch (\Exception $exception) {
            $this->transactionManager->rollBack();

            throw new CouldNotSaveException(__('Could not save entity type'), $exception);
        }

        return $entityType;
    }

    /**
     * Populate default values for entity type properties
     *
     * @param EntityTypeInterface $entityType
     */
    private function populateDefaultValues(EntityTypeInterface $entityType): void
    {
        $entityType->setEntityModel(\Magento\Eav\Model\Entity::class);
        $entityType->setEntityTable($this->tableNameResolver->resolve($entityType));
    }

    /**
     * Create default entity type attribute set and attribute group
     *
     * @param EntityTypeInterface $entityType
     */
    private function createDefaultSetAndGroup(EntityTypeInterface $entityType): void
    {
        $attributeSet = $this->attributeSetFactory->create();
        $attributeSet->setAttributeSetName('Default');
        $attributeSet->setEntityTypeId($entityType->getEntityTypeId());
        $attributeSet->setSortOrder(1);

        $this->attributeSetRepository->save($attributeSet);

        $entityType->setDefaultAttributeSetId((int) $attributeSet->getAttributeSetId());
        $this->resource->save($entityType);

        $attributeGroup = $this->attributeGroupFactory->create(['data' => ['sort_order' => 1]]);
        $attributeGroup->setAttributeSetId($attributeSet->getAttributeSetId());
        $attributeGroup->setAttributeGroupName('General');

        $this->attributeGroupRepository->save($attributeGroup);
    }
}
