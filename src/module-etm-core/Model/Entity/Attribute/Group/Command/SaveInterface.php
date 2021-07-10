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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Group\Command;

use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

interface SaveInterface
{

    /**
     * Save attribute group data
     *
     * @param AttributeGroupInterface $attributeGroup
     *
     * @return int
     *
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function execute(AttributeGroupInterface $attributeGroup): int;
}
