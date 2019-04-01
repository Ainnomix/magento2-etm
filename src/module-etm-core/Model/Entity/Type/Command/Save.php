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

namespace Ainnomix\EtmCore\Model\Entity\Type\Command;

use Ainnomix\EtmApi\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save Entity Type command
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmCore
 */
class Save implements SaveInterface
{

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType): int
    {
        throw new CouldNotSaveException(__(""));
    }
}
