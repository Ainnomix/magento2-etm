<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType\Command;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Get Entity Type by typeCode command (Service Provider Interface - SPI)
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 */
interface GetInterface
{

    /**
     * Get Entity type by given entityTypeCode
     *
     * @param string $entityTypeCode
     *
     * @return EntityTypeInterface
     *
     * @throws NoSuchEntityException
     */
    public function execute(string $entityTypeCode): EntityTypeInterface;
}
