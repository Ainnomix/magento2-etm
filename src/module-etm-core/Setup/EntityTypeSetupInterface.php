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

namespace Ainnomix\EtmCore\Setup;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

interface EntityTypeSetupInterface
{

    /**
     * Install entity type data
     *
     * @param EntityTypeInterface $entity
     */
    public function install(EntityTypeInterface $entity): void;

    /**
     * Uninstall entity type data
     *
     * @param EntityTypeInterface $entity
     */
    public function uninstall(EntityTypeInterface $entity): void;
}
