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
use Ainnomix\EtmCore\Model\ResourceModel\Entity\TableNameResolver;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Stdlib\StringUtils;
use Zend_Db_Exception;

class TypeTableSetup extends AbstractTableEntityTypeSetup
{

    /**
     * Default indexes configuration
     *
     * @var array
     */
    protected array $defaultIndexes = [
        'entityAttributeStore' => [
            'columns' => [
                'entity_id' => ['name' => 'entity_id'],
                'attribute_id' => ['name' => 'attribute_id'],
                'store_id' => ['name' => 'store_id']
            ],
            'type' => AdapterInterface::INDEX_TYPE_UNIQUE
        ],
        'storeId' => [
            'columns' => [
                'store_id' => ['name' => 'store_id']
            ]
        ],
        'attributeValue' => [
            'columns' => [
                'attribute_id' => ['name' => 'attribute_id'],
                'value' => ['name' => 'value']
            ]
        ]
    ];

    /**
     * Class dependencies and configuration
     *
     * @param ModuleDataSetupInterface $setup
     * @param StringUtils $string
     * @param TableNameResolver $tableNameResolver
     * @param string $tableSuffix
     * @param string $columnType
     * @param array $options
     * @param array|null $indexes
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        StringUtils $string,
        TableNameResolver $tableNameResolver,
        protected string $tableSuffix,
        protected string $columnType,
        protected array $options = [],
        array $indexes = null
    ) {
        parent::__construct(
            $setup,
            $string,
            $tableNameResolver
        );

        if (is_array($indexes)) {
            $this->defaultIndexes = array_replace_recursive($this->defaultIndexes, $indexes);
        }
    }

    /**
     * @inheritDoc
     *
     * @throws Zend_Db_Exception
     */
    public function install(EntityTypeInterface $entity): void
    {
        $tableName = $this->tableNameResolver->resolve($entity);
        $typeTableName = sprintf('%s_%s', $tableName, $this->tableSuffix);

        $table = $this->getConnection()->newTable($typeTableName)
            ->setComment($this->string->upperCaseWords($typeTableName, '_', ' '));

        $table->addColumn(
            'value_id',
            Table::TYPE_INTEGER,
            null,
            [
                'primary' => true,
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
            ],
            'Value ID'
        );

        $table->addColumn(
            'attribute_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => 0
            ],
            'Attribute ID'
        );

        $table->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => 0
            ],
            'Store ID'
        );

        $table->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => 0
            ],
            'Entity ID'
        );

        $table->addColumn(
            'value',
            $this->columnType,
            $this->options['length'] ?? null,
            $this->options['options'] ?? ['nullable' => true],
            'Attribute Value'
        );

        foreach ($this->defaultIndexes as $index) {
            $table->addIndex(
                $this->getConnection()->getIndexName(
                    $typeTableName,
                    array_keys($index['columns']),
                    $index['type'] ?? AdapterInterface::INDEX_TYPE_INDEX
                ),
                $index['columns'],
                ['type' => $index['type'] ?? AdapterInterface::INDEX_TYPE_INDEX]
            );
        }

        $table->addForeignKey(
            $this->getConnection()->getForeignKeyName(
                $typeTableName,
                'entity_id',
                $tableName,
                'entity_id'
            ),
            'entity_id',
            $tableName,
            'entity_id',
            Table::ACTION_CASCADE
        );

        $table->addForeignKey(
            $this->getConnection()->getForeignKeyName(
                $typeTableName,
                'store_id',
                $this->getConnection()->getTableName('store'),
                'store_id'
            ),
            'store_id',
            $this->getConnection()->getTableName('store'),
            'store_id',
            Table::ACTION_CASCADE
        );

        $table->addForeignKey(
            $this->getConnection()->getForeignKeyName(
                $typeTableName,
                'attribute_id',
                $this->getConnection()->getTableName('eav_attribute'),
                'attribute_id'
            ),
            'attribute_id',
            $this->getConnection()->getTableName('eav_attribute'),
            'attribute_id',
            Table::ACTION_CASCADE
        );

        $this->getConnection()->createTable($table);
    }

    /**
     * @inheritDoc
     */
    public function uninstall(EntityTypeInterface $entity): void
    {
        $tableName = $this->tableNameResolver->resolve($entity);
        $typeTableName = sprintf('%s_%s', $tableName, $this->tableSuffix);

        $this->getConnection()->dropTable($typeTableName);
    }
}
