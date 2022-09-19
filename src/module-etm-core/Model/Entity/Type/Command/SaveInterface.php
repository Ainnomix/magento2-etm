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

namespace Ainnomix\EtmCore\Model\Entity\Type\Command;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotSaveException;

interface SaveInterface
{

    /**
     * Save entity type data
     *
     * @param EntityTypeInterface $entityType
     *
     * @return EntityTypeInterface
     *
     * @throws CouldNotSaveException
     */
    public function execute(EntityTypeInterface $entityType): EntityTypeInterface;
}
