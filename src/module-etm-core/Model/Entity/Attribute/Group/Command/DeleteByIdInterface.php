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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Group\Command;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

interface DeleteByIdInterface
{

    /**
     * Delete attribute group by ID. If entity does not exist do nothing
     *
     * @param int $groupId Attribute group ID
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function execute(int $groupId): void;
}
