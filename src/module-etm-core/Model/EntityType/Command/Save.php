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

namespace Ainnomix\EtmCore\Model\EntityType\Command;

use Ainnomix\EtmCore\Model\EntityType;
use Ainnomix\EtmCore\Model\EntityTypeFactory;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as Resource;
use Exception;
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

    public function __construct(
        EntityTypeFactory $entityTypeFactory,
        DataObjectProcessor $dataObjectProcessor,
        Resource $entityTypeResource
    ) {
        $this->entityTypeFactory = $entityTypeFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->entityTypeResource = $entityTypeResource;
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
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save entity type'), $exception);
        }

        return (int) $typeTypeModel->getEntityTypeId();
    }

    private function populateDefaultValues(EntityType $entityType)
    {
        $entityType->isCustom(true);
        $entityType->setEntityModel(\Magento\Eav\Model\Entity::class);
    }
}
