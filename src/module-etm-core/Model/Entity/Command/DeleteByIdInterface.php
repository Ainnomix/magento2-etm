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

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

interface DeleteByIdInterface
{

    /**
     * Delete entity by ID
     *
     * @param EntityTypeInterface $entityType
     * @param int $entityId
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function execute(EntityTypeInterface $entityType, int $entityId): void;
}
