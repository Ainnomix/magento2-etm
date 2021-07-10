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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Command;

use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface GetByIdInterface
{

    /**
     * Load entity attribute by attribute ID
     *
     * @param int $attributeId
     *
     * @return AttributeInterface
     *
     * @throws NoSuchEntityException
     */
    public function execute(int $attributeId): AttributeInterface;
}
