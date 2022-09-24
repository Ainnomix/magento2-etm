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
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Stdlib\StringUtils;
use Zend_Db_Exception;

abstract class AbstractTableSetup
{

    /**
     * Class dependencies and configuration
     *
     * @param ResourceConnection $resources
     * @param StringUtils $string
     * @param TableNameResolver $tableNameResolver
     * @param string|null $connectionName
     */
    public function __construct(
        protected ResourceConnection $resources,
        protected StringUtils $string,
        protected TableNameResolver $tableNameResolver,
        protected string|null $connectionName = null
    ) {
    }

    /**
     * Create database table
     *
     * @param EntityTypeInterface $entityType
     *
     * @throws Zend_Db_Exception
     */
    abstract public function createTable(EntityTypeInterface $entityType): void;

    /**
     * Drop database table
     *
     * @param EntityTypeInterface $entityType
     */
    abstract public function dropTable(EntityTypeInterface $entityType): void;

    /**
     * Get current DB connection
     *
     * @return AdapterInterface
     */
    protected function getConnection(): AdapterInterface
    {
        return $this->resources->getConnection($this->connectionName);
    }
}
