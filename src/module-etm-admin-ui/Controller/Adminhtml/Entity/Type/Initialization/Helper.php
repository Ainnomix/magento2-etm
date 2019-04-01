<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\Entity\Type\Initialization;

use Ainnomix\EtmApi\Api\Data\EntityTypeInterface;
use Ainnomix\EtmApi\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmApi\Api\EntityTypeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Edit entity initialization helper
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Helper
{

    /**
     * Entity type repository
     *
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    /**
     * Entity type factory
     *
     * @var EntityTypeInterfaceFactory
     */
    protected $entityTypeFactory;

    /**
     * Helper constructor
     *
     * @param EntityTypeRepositoryInterface $entityTypeRepository
     * @param EntityTypeInterfaceFactory $entityTypeFactory
     */
    public function __construct(
        EntityTypeRepositoryInterface $entityTypeRepository,
        EntityTypeInterfaceFactory $entityTypeFactory
    ) {
        $this->entityTypeRepository = $entityTypeRepository;
        $this->entityTypeFactory = $entityTypeFactory;
    }

    /**
     * Retrieve entity type model by ID.
     * If entity with this code does not exist an empty entity will by created.
     *
     * @param int $entityTypeId Entity type ID
     *
     * @return EntityTypeInterface
     */
    public function getById(int $entityTypeId): EntityTypeInterface
    {
        try {
            $entityType = $this->entityTypeRepository->getById($entityTypeId);
        } catch (NoSuchEntityException $exception) {
            $entityType = $this->entityTypeFactory->create();
        }

        return $entityType;
    }
}
