<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType\Command;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save Entity Type command (Service Provider Interface - SPI)
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 */
interface SaveInterface
{

    /**
     * Save Entity type data
     *
     * @param EntityTypeInterface $entityType
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function execute(EntityTypeInterface $entityType): int;
}
