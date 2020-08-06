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

use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface GetInterface
{

    /**
     * Load entity attribute by given type code and attribute code
     *
     * @param string $entityTypeCode
     * @param string $attributeCode
     *
     * @return AttributeInterface
     *
     * @throws NoSuchEntityException
     */
    public function execute(string $entityTypeCode, string $attributeCode): AttributeInterface;
}
