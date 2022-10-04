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

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\ResourceRegistry;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;

class Save implements SaveInterface
{

    /**
     * Class dependencies
     *
     * @param ResourceRegistry $resourceRegistry
     */
    public function __construct(
        protected ResourceRegistry $resourceRegistry
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(string $typeCode, EntityInterface $entity): EntityInterface
    {
        try {
            $resource = $this->resourceRegistry->getOrCreate($typeCode);
            $resource->save($entity);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save entity'), $exception);
        }

        return $entity;
    }
}
