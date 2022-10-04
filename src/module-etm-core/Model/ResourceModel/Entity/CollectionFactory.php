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

namespace Ainnomix\EtmCore\Model\ResourceModel\Entity;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validator\UniversalFactory;

class CollectionFactory
{

    /**
     * Class dependencies
     *
     * @param UniversalFactory $universalFactory
     * @param ResourceRegistry $resourceRegistry
     */
    public function __construct(
        protected UniversalFactory $universalFactory,
        protected ResourceRegistry $resourceRegistry
    ) {
    }

    /**
     * Create entity collection instance
     *
     * @param EntityTypeInterface|string $entityType
     * @param array $data
     *
     * @return Collection
     *
     * @throws LocalizedException|NoSuchEntityException
     */
    public function create(EntityTypeInterface|string $entityType, array $data = []): Collection
    {
        $resource = $this->resourceRegistry->getOrCreate($entityType);
        $data['resourceEntity'] = $resource;

        return $this->universalFactory->create(Collection::class, $data);
    }
}
