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

namespace Ainnomix\EtmCore\Setup\EntityTypeSetup;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\DB\Ddl\Table;
use Zend_Db_Exception;

class MainTableSetup extends AbstractTableEntityTypeSetup
{

    /**
     * @inheritDoc
     *
     * @throws Zend_Db_Exception
     */
    public function install(EntityTypeInterface $entity): void
    {
        $tableName = $this->tableNameResolver->resolve($entity);

        $table = $this->getConnection()->newTable($tableName)
            ->setComment($this->string->upperCaseWords($tableName, '_', ' '));

        $table->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            [
                'primary' => true,
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
            ],
            'Entity ID'
        );

        $table->addColumn(
            'attribute_set_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default'  => 0
            ],
            'Attribute Set ID'
        );

        $table->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default'  => Table::TIMESTAMP_INIT
            ],
            'Created At'
        );

        $table->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default'  => Table::TIMESTAMP_INIT_UPDATE
            ],
            'Updated At'
        );

        $this->getConnection()->createTable($table);
    }

    /**
     * @inheritDoc
     */
    public function uninstall(EntityTypeInterface $entity): void
    {
        $tableName = $this->tableNameResolver->resolve($entity);

        $this->getConnection()->dropTable($tableName);
    }
}
