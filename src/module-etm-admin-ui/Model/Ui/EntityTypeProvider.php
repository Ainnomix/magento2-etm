<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Model\Ui;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class EntityTypeProvider
{

    /**
     * @var EntityTypeRepositoryInterface
     */
    private $entityTypeRepository;

    /**
     * @var EntityTypeInterfaceFactory
     */
    private $entityTypeFactory;

    /**
     * @var EntityTypeInterface[]
     */
    private $entityTypeCache = [];

    /**
     * EntityTypeProvider constructor
     *
     * @param EntityTypeRepositoryInterface $entityTypeRepository
     * @param EntityTypeInterfaceFactory    $entityTypeFactory
     */
    public function __construct(
        EntityTypeRepositoryInterface $entityTypeRepository,
        EntityTypeInterfaceFactory $entityTypeFactory
    ) {
        $this->entityTypeRepository = $entityTypeRepository;
        $this->entityTypeFactory = $entityTypeFactory;
    }

    /**
     * Retrieve entity type instance by ID
     *
     * @param int $entityTypeId Entity type instance ID
     *
     * @return EntityTypeInterface
     *
     * @throws NoSuchEntityException
     */
    public function get(int $entityTypeId): EntityTypeInterface
    {
        if (isset($this->entityTypeCache[$entityTypeId])) {
            return $this->entityTypeCache[$entityTypeId];
        }

        if (0 === $entityTypeId) {
            return $this->entityTypeCache[$entityTypeId] = $this->entityTypeFactory->create();
        }

        $entityType = $this->entityTypeRepository->getById($entityTypeId);

        return $this->entityTypeCache[$entityTypeId] = $entityType;
    }
}
