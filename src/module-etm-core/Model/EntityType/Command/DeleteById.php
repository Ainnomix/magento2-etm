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

namespace Ainnomix\EtmCore\Model\EntityType\Command;

use Ainnomix\EtmCore\Model\EntityTypeFactory;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as Resource;
use Ainnomix\EtmCore\Model\ResourceModel\EntityTypeSetup;
use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Delete Entity Type by typeId command
 */
class DeleteById implements DeleteByIdInterface
{

    /**
     * @var EntityTypeFactory
     */
    protected $entityTypeFactory;

    /**
     * @var Resource
     */
    protected $entityTypeResource;

    /**
     * @var EntityTypeSetup
     */
    private $entityTypeSetup;

    /**
     * DeleteById Command constructor
     *
     * @param EntityTypeFactory $entityTypeFactory
     * @param Resource $entityTypeResource
     * @param EntityTypeSetup $entityTypeSetup
     */
    public function __construct(
        EntityTypeFactory $entityTypeFactory,
        Resource $entityTypeResource,
        EntityTypeSetup $entityTypeSetup
    ) {
        $this->entityTypeFactory = $entityTypeFactory;
        $this->entityTypeResource = $entityTypeResource;
        $this->entityTypeSetup = $entityTypeSetup;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(int $entityTypeId): void
    {
        $entityType = $this->entityTypeFactory->create();
        $this->entityTypeResource->load($entityType, $entityTypeId, 'entity_type_id');

        if (null === $entityType->getId()) {
            throw new NoSuchEntityException(
                __(
                    'There is no entity type with "%fieldValue" for "%fieldName". Verify and try again.',
                    [
                        'fieldName' => 'entity_type_id',
                        'fieldValue' => $entityTypeId
                    ]
                )
            );
        }

        try {
            $this->entityTypeSetup->dropEntityTypeTables($entityType);
            $this->entityTypeResource->delete($entityType);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete entity type. %1', $exception->getMessage()),
                $exception
            );
        }
    }
}
