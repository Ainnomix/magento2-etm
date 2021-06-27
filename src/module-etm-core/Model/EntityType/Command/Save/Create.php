<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType\Command\Save;

use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Ainnomix\EtmCore\Api\AttributeGroupRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterfaceFactory;
use Ainnomix\EtmCore\Model\ResourceModel\Entity;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as Resource;
use Ainnomix\EtmCore\Model\ResourceModel\EntityTypeSetup;

class Create implements OperationInterface
{

    /**
     * @var Resource
     */
    private $resource;

    /**
     * @var EntityTypeSetup
     */
    private $entityTypeSetup;

    /**
     * @var AttributeSetInterfaceFactory
     */
    private $attributeSetFactory;

    /**
     * @var AttributeSetRepositoryInterface
     */
    private $attributeSetRepository;

    /**
     * @var AttributeGroupInterfaceFactory
     */
    private $attributeGroupFactory;

    /**
     * @var AttributeGroupRepositoryInterface
     */
    private $attributeGroupRepository;

    public function __construct(
        Resource $resource,
        EntityTypeSetup $entityTypeSetup,
        AttributeSetInterfaceFactory $attributeSetFactory,
        AttributeSetRepositoryInterface $attributeSetRepository,
        AttributeGroupInterfaceFactory $attributeGroupFactory,
        AttributeGroupRepositoryInterface $attributeGroupRepository
    ) {
        $this->resource = $resource;
        $this->entityTypeSetup = $entityTypeSetup;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->attributeGroupFactory = $attributeGroupFactory;
        $this->attributeGroupRepository = $attributeGroupRepository;
    }

    public function execute(EntityTypeInterface $entityType): void
    {
        $this->populateDefaultValues($entityType);

        $this->resource->save($entityType);
        $this->createDefaultAttributeSet($entityType);
        $this->entityTypeSetup->setupEntityTypeTables($this->generateTableName($entityType));
    }

    private function populateDefaultValues(EntityTypeInterface $entityType)
    {
        $entityType->isCustom(true);
        $entityType->setEntityModel(Entity::class);
        $entityType->setEntityTable($this->generateTableName($entityType));
    }

    private function createDefaultAttributeSet(EntityTypeInterface $entityType): void
    {
        /** @var AttributeSetInterface $attributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeSet->setAttributeSetName('Default');
        $attributeSet->setEntityTypeId($entityType->getEntityTypeId());
        $attributeSet->setSortOrder(1);

        $this->attributeSetRepository->save($attributeSet);

        $entityType->setDefaultAttributeSetId((int) $attributeSet->getAttributeSetId());
        $this->resource->save($entityType);

        $this->createDefaultAttributeGroup($attributeSet);
    }

    private function createDefaultAttributeGroup(AttributeSetInterface $attributeSet): void
    {
        /** @var AttributeGroupInterface $attributeGroup */
        $attributeGroup = $this->attributeGroupFactory->create(['data' => ['sort_order' => 1]]);
        $attributeGroup->setAttributeSetId($attributeSet->getAttributeSetId());
        $attributeGroup->setAttributeGroupName('General');

        $this->attributeGroupRepository->save($attributeGroup);
    }

    private function generateTableName(EntityTypeInterface $entityType): string
    {
        return sprintf('etm_%s_entity', $entityType->getEntityTypeCode());
    }
}
