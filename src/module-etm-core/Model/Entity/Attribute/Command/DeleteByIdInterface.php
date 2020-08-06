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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Command;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

interface DeleteByIdInterface
{

    /**
     * Delete entity attribute by ID
     *
     * @param int $attributeId
     *
     * @return void
     *
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function execute(int $attributeId): void;
}
