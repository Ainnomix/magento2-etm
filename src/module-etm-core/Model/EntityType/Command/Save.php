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

namespace Ainnomix\EtmCore\Model\EntityType\Command;

use Exception;
use Ainnomix\EtmCore\Model\EntityType;
use Ainnomix\EtmCore\Model\EntityTypeFactory;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as Resource;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Ainnomix\EtmCore\Api\AttributeGroupRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterfaceFactory;
use Magento\Eav\Model\Entity;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save Entity Type command
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 */
class Save implements SaveInterface
{

    /**
     * @var EntityTypeFactory
     */
    protected $entityTypeFactory;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var Resource
     */
    private $entityTypeResource;

    /**
     * @var AttributeSetRepositoryInterface
     */
    private $attributeSetRepository;

    /**
     * @var AttributeSetInterfaceFactory
     */
    private $attributeSetFactory;

    /**
     * @var AttributeGroupRepositoryInterface
     */
    private $attributeGroupRepository;

    /**
     * @var AttributeGroupInterfaceFactory
     */
    private $attributeGroupFactory;

    public function __construct(
        EntityTypeFactory $entityTypeFactory,
        DataObjectProcessor $dataObjectProcessor,
        Resource $entityTypeResource,
        AttributeSetRepositoryInterface $attributeSetRepository,
        AttributeSetInterfaceFactory $attributeSetFactory,
        AttributeGroupRepositoryInterface $attributeGroupRepository,
        AttributeGroupInterfaceFactory $attributeGroupFactory
    ) {
        $this->entityTypeFactory = $entityTypeFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->entityTypeResource = $entityTypeResource;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->attributeGroupFactory = $attributeGroupFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType): int
    {
        $typeTypeData = $this->dataObjectProcessor->buildOutputDataArray(
            $entityType,
            EntityTypeInterface::class
        );
        $typeTypeModel = $this->entityTypeFactory->create(['data' => $typeTypeData]);
        $this->populateDefaultValues($typeTypeModel);

        try {
            $this->entityTypeResource->save($typeTypeModel);
            if (!$entityType->getEntityTypeId()) {
                $this->processNewEntity($typeTypeModel);
            }
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save entity type.'), $exception);
        }

        return (int) $typeTypeModel->getEntityTypeId();
    }

    private function processNewEntity(EntityType $entityType): void
    {
        /** @var AttributeSetInterface $attributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeSet->setAttributeSetName('Default');
        $attributeSet->setEntityTypeId($entityType->getEntityTypeId());
        $attributeSet->setSortOrder(1);

        $this->attributeSetRepository->save($attributeSet);

        $entityType->setDefaultAttributeSetId((int) $attributeSet->getAttributeSetId());
        $this->entityTypeResource->save($entityType);

        /** @var AttributeGroupInterface $attributeGroup */
        $attributeGroup = $this->attributeGroupFactory->create(['data' => ['sort_order' => 1]]);
        $attributeGroup->setAttributeSetId($attributeSet->getAttributeSetId());
        $attributeGroup->setAttributeGroupName('General');

        $this->attributeGroupRepository->save($attributeGroup);
    }

    private function populateDefaultValues(EntityType $entityType)
    {
        $entityType->isCustom(true);
        $entityType->setEntityModel(Entity::class);
    }
}
