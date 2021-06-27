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

use Ainnomix\EtmCore\Model\EntityType\Command\Save\OperationPool;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as Resource;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Model\ResourceModel\Db\TransactionManagerInterface;
use Exception;

/**
 * Save Entity Type command
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 */
class Save implements SaveInterface
{

    /**
     * @var Resource
     */
    private $entityTypeResource;

    /**
     * @var TransactionManagerInterface
     */
    private $transactionManager;

    /**
     * @var OperationPool
     */
    private $operationPool;

    public function __construct(
        Resource $entityTypeResource,
        TransactionManagerInterface $transactionManager,
        OperationPool $operationPool
    ) {
        $this->entityTypeResource = $entityTypeResource;
        $this->transactionManager = $transactionManager;
        $this->operationPool = $operationPool;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType): int
    {
        $this->transactionManager->start($this->entityTypeResource->getConnection());

        try {
            $operation = $this->operationPool->getOperation('create');
            if (!$entityType->isObjectNew()) {
                $operation = $this->operationPool->getOperation('update');
            }

            $operation->execute($entityType);

            $this->transactionManager->commit();
        } catch (Exception $exception) {
            $this->transactionManager->rollBack();

            throw new CouldNotSaveException(__('Could not save entity type. %1', $exception->getMessage()), $exception);
        }

        return (int) $entityType->getEntityTypeId();
    }
}
