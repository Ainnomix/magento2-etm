<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Set\Command;

use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Magento\Framework\Exception\CouldNotSaveException;

interface SaveInterface
{

    /**
     * Save attribute set data
     *
     * @param AttributeSetInterface $attributeSet
     *
     * @return int
     *
     * @throws CouldNotSaveException
     */
    public function execute(AttributeSetInterface $attributeSet): int;
}
