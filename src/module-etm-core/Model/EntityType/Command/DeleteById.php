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

use Ainnomix\EtmCore\Model\EntityTypeFactory;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as Resource;
use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Delete Entity Type by typeId command
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
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
     * DeleteById Command constructor
     *
     * @param EntityTypeFactory $entityTypeFactory
     * @param Resource $entityTypeResource
     */
    public function __construct(
        EntityTypeFactory $entityTypeFactory,
        Resource $entityTypeResource
    ) {
        $this->entityTypeFactory = $entityTypeFactory;
        $this->entityTypeResource = $entityTypeResource;
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
            $this->entityTypeResource->delete($entityType);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete entity type. %1', $exception->getMessage()), $exception);
        }
    }
}
