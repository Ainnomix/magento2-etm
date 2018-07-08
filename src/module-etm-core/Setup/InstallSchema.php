<?php
declare(strict_types=1);

/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_EtmCore
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2018 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Ainnomix\EtmCore\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Setup class for additional database schemas
 *
 * @category Ainnomix_EtmCore
 * @package  Ainnomix\EtmCore
 * @author   Roman Tomchak <romantomchak@ainnomix.com>
 */
class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('etm_eav_entity_type'))
            ->addColumn(
                'entity_type_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                5,
                ['unsigned' => true, 'nullable' => false]
            )
            ->addColumn(
                'entity_type_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                ['nullable' => false]
            )
            ->addForeignKey(
                $installer->getFkName(
                    'etm_eav_entity_type',
                    'entity_type_id',
                    'eav_entity_type',
                    'entity_type_id'
                ),
                'entity_type_id',
                $installer->getTable('eav_entity_type'),
                'entity_type_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Additional Entity Types table');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
