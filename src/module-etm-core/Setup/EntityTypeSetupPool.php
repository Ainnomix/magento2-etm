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

class EntityTypeSetupPool implements EntityTypeSetupInterface
{

    /**
     * Class dependencies
     *
     * @param EntityTypeSetupInterface[] $setupPool
     */
    public function __construct(
        protected array $setupPool
    ) {
    }

    /**
     * Create entity type data
     *
     * @param EntityTypeInterface $entity
     */
    public function install(EntityTypeInterface $entity): void
    {
        foreach ($this->setupPool as $setup) {
            $setup->install($entity);
        }
    }

    /**
     * Drop entity type data
     *
     * @param EntityTypeInterface $entity
     */
    public function uninstall(EntityTypeInterface $entity): void
    {
        foreach ($this->setupPool as $setup) {
            $setup->uninstall($entity);
        }
    }
}
