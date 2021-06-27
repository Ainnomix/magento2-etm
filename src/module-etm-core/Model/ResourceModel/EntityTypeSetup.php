<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Stdlib\StringUtils;

class EntityTypeSetup
{

    /**
     * @var ResourceConnection
     */
    private $resources;

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
                'scale' => 12,
                'precision' => 4,
                'nullable' => false,
                'default' => 0.0
            ]
        ],
        'text' => [
            'type' => Table::TYPE_TEXT,
            'length' => null,
            'options' => [
                'nullable' => true
            ]
        ]
    ];

    public function __construct(ResourceConnection $resources, StringUtils $string, string $connectionName = null)
    {
        $this->resources = $resources;
        $this->string = $string;
        if (!is_null($connectionName)) {
            $this->connectionName = $connectionName;
        }
    }

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection()
    {
        $fullResourceName = ($this->connectionName ? $this->connectionName : ResourceConnection::DEFAULT_CONNECTION);
        return $this->resources->getConnection($fullResourceName);
    }

    public function setupEntityTypeTables(string $tableName): void
    {
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

            $indexes = [
                ['columns' => ['entity_id', 'attribute_id', 'store_id'], 'type' => AdapterInterface::INDEX_TYPE_UNIQUE],
                ['columns' => ['store_id']],
                ['columns' => ['attribute_id', 'value']],
                ['columns' => ['entity_type_id', 'value']]
            ];
            foreach ($indexes as $index) {
                $table->addIndex(
                    $this->getConnection()->getIndexName(
                        $typeTableName,
                        $index['columns'],
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
