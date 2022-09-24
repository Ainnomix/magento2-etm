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

namespace Ainnomix\EtmCore\Setup;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Setup\EntityTypeSetup\MainTableSetup;
use Ainnomix\EtmCore\Setup\EntityTypeSetup\TypeTableSetup;
use Zend_Db_Exception;

class EntityTypeSetup
{

    /**
     * Class dependencies
     *
     * @param MainTableSetup $mainTableSetup
     * @param TypeTableSetup[] $typedTablesSetupPool
     */
    public function __construct(
        protected MainTableSetup $mainTableSetup,
        protected array $typedTablesSetupPool
    ) {
    }

    /**
     * Create entity type tables
     *
     * @param EntityTypeInterface $entityType
     *
     * @throws Zend_Db_Exception
     */
    public function createEntityTypeTables(EntityTypeInterface $entityType): void
    {
        $this->mainTableSetup->createTable($entityType);

        foreach ($this->typedTablesSetupPool as $tableSetup) {
            $tableSetup->createTable($entityType);
        }
    }

    /**
     * Drop entity type tables
     *
     * @param EntityTypeInterface $entityType
     */
    public function dropEntityTypeTables(EntityTypeInterface $entityType): void
    {
        foreach ($this->typedTablesSetupPool as $tableSetup) {
            $tableSetup->dropTable($entityType);
        }

        $this->mainTableSetup->dropTable($entityType);
    }
}
