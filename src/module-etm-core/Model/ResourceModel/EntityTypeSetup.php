<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Stdlib\StringUtils;

/**
 * Entity type tables setup model
 *
 * @author Roman Tomchak <roman@ainnomix.com>
 */
class EntityTypeSetup
{

    /**
     * @var ResourceConnection
     */
    private $resources;

    /**
     * @var EntityTableNameResolverInterface
     */
    private $tableNameResolver;

    /**
     * @var StringUtils
     */
    private $string;

    /**
     * @var string|null
     */
    private $connectionName;

    private $types = [
        'varchar' => [
            'type' => Table::TYPE_TEXT,
            'length' => 255,
            'options' => [
                'nullable' => true
            ]
        ],
        'int' => [
            'type' => Table::TYPE_INTEGER,
            'length' => null,
            'options' => [
                'unsigned' => false,
                'nullable' => false,
                'default' => 0
            ]
        ],
        'datetime' => [
            'type' => Table::TYPE_DATETIME,
            'length' => null,
            'options' => [
                'nullable' => true
            ]
        ],
        'decimal' => [
            'type' => Table::TYPE_DECIMAL,
            'length' => null,
            'options' => [
                'scale' => 4,
                'precision' => 12,
                'nullable' => false,
                'default' => 0.0
            ]
        ],
        'text' => [
            'type' => Table::TYPE_TEXT,
            'length' => null,
            'options' => [
                'nullable' => true
            ],
            'addIndexes' => [
                'attributeValue' => [
                    'columns' => [
                        'attribute_id' => ['name' => 'attribute_id'],
                        'value' => ['name' => 'value', 'size' => 255]
                    ]
                ]
            ]
        ]
    ];

    private $defaultIndexes = [
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

    public function __construct(
        ResourceConnection $resources,
        EntityTableNameResolverInterface $tableNameResolver,
        StringUtils $string,
        string $connectionName = null
    ) {
        $this->resources = $resources;
        $this->tableNameResolver = $tableNameResolver;
        $this->string = $string;
        if (null !== $connectionName) {
            $this->connectionName = $connectionName;
        }
    }

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection()
    {
        return $this->resources->getConnection($this->connectionName);
    }

    public function setupEntityTypeTables(EntityTypeInterface $entityType): void
    {
        $tableName = $this->tableNameResolver->resolve($entityType);

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
        $this->createAttributeTypeTables($tableName);
    }

    /**
     * Drop entity type tables
     *
     * @param EntityTypeInterface $entityType
     */
    public function dropEntityTypeTables(EntityTypeInterface $entityType): void
    {
        $tableName = $this->tableNameResolver->resolve($entityType);
        foreach (array_keys($this->types) as $type) {
            $typeTableName = sprintf('%s_%s', $tableName, $type);

            $this->getConnection()->dropTable($typeTableName);
        }

        $this->getConnection()->dropTable($tableName);
    }

    private function createAttributeTypeTables(string $tableName): void
    {
        foreach ($this->types as $type => $config) {
            $typeTableName = sprintf('%s_%s', $tableName, $type);

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
                $config['type'],
                $config['length'],
                $config['options'],
                'Attribute Value'
            );

            $indexes = array_replace_recursive($this->defaultIndexes, $config['addIndexes'] ?? []);
            foreach ($indexes as $index) {
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
    }
}
