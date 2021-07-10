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

namespace Ainnomix\EtmCore\Model\Entity\Command;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\ResourceModel\Entity;
use Magento\Framework\Exception\CouldNotSaveException;
use Exception;

class Save implements SaveInterface
{

    /**
     * @var Entity
     */
    protected $resource;

    public function __construct(Entity $resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(EntityTypeInterface $entityType, EntityInterface $entity): int
    {
        try {
            $this->resource->setType($entityType);
            $this->resource->save($entity);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save entity'), $exception);
        }

        return (int) $entity->getId();
    }
}
