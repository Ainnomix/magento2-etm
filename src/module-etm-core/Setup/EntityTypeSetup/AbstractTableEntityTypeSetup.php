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

use Ainnomix\EtmCore\Model\ResourceModel\Entity\TableNameResolver;
use Ainnomix\EtmCore\Setup\EntityTypeSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Stdlib\StringUtils;

abstract class AbstractTableEntityTypeSetup implements EntityTypeSetupInterface
{

    /**
     * Class dependencies and configuration
     *
     * @param ModuleDataSetupInterface $setup
     * @param StringUtils $string
     * @param TableNameResolver $tableNameResolver
     */
    public function __construct(
        protected ModuleDataSetupInterface $setup,
        protected StringUtils $string,
        protected TableNameResolver $tableNameResolver
    ) {
    }

    /**
     * Get current DB connection
     *
     * @return AdapterInterface
     */
    protected function getConnection(): AdapterInterface
    {
        return $this->setup->getConnection();
    }
}
