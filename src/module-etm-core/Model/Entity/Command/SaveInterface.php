<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotSaveException;

interface SaveInterface
{

    /**
     * Save entity data
     *
     * @param EntityTypeInterface $entityType
     * @param EntityInterface $entity
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function execute(EntityTypeInterface $entityType, EntityInterface $entity): int;
}
