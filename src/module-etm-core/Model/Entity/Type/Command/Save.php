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

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\Entity;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\TableNameResolver;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Type as Resource;
use Ainnomix\EtmCore\Setup\EntityTypeSetupInterface;
use Exception;
use Magento\Eav\Model\Config;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Model\ResourceModel\Db\TransactionManagerInterface;

class Save implements SaveInterface
{

    /**
     * Class dependencies
     *
     * @param TransactionManagerInterface $transactionManager
     * @param TableNameResolver $tableNameResolver
     * @param Resource $resource
     * @param EntityTypeSetupInterface $typeDataSetup
     * @param EntityTypeSetupInterface $typeTableSetup
     * @param Config $eavConfig
     */
    public function __construct(
        protected TransactionManagerInterface $transactionManager,
        protected TableNameResolver $tableNameResolver,
        protected Resource $resource,
        protected EntityTypeSetupInterface $typeDataSetup,
        protected EntityTypeSetupInterface $typeTableSetup,
        protected Config $eavConfig
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
                $this->typeDataSetup->install($entityType);
            }

            $this->transactionManager->commit();

            if ($creationFlag) {
                $this->typeTableSetup->install($entityType);
            }
        } catch (Exception $exception) {
            $this->transactionManager->rollBack();

            throw new CouldNotSaveException(__('Could not save entity type'), $exception);
        } finally {
            $this->eavConfig->clear();
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
        $entityType->setEntityModel(Entity::class);
        $entityType->setEntityTable($this->tableNameResolver->resolve($entityType));
    }
}
