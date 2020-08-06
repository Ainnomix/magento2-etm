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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Set\Command;

use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface GetInterface
{

    /**
     * Get attribute set by given set ID
     *
     * @param int $attributeSetId
     *
     * @return AttributeSetInterface
     *
     * @throws NoSuchEntityException
     */
    public function execute(int $attributeSetId): AttributeSetInterface;
}
