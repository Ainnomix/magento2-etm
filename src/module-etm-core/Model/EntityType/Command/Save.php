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

use Ainnomix\EtmCore\Model\EntityType\Command\Save\OperationPool;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Exception;

/**
 * Save Entity Type command
 *
 * @author Roman Tomchak <romantomchak@gmail.com>
 */
class Save implements SaveInterface
{

    /**
     * @var OperationPool
     */
    private $operationPool;

    public function __construct(
        OperationPool $operationPool
    ) {
        $this->operationPool = $operationPool;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType): int
    {
        try {
            $operation = $this->operationPool->getOperation('create');
            if (!$entityType->isObjectNew()) {
                $operation = $this->operationPool->getOperation('update');
            }

            $operation->execute($entityType);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save entity type. %1', $exception->getMessage()), $exception);
        }

        return (int) $entityType->getEntityTypeId();
    }
}
