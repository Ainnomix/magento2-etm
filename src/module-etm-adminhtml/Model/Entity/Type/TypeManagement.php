<?php
declare(strict_types=1);

/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_EtmAdminhtml
 * @package   Ainnomix\EtmAdminhtml
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2018 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Ainnomix\EtmAdminhtml\Model\Entity\Type;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;


/**
 * {{DESCRIPTION}}
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@ainnomix.com>
 */
class TypeManagement
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
    private $cachedEntities = [];

    public function __construct(
        EntityTypeRepositoryInterface $entityTypeRepository,
        EntityTypeInterfaceFactory $entityTypeFactory
    ) {
        $this->entityTypeRepository = $entityTypeRepository;
        $this->entityTypeFactory = $entityTypeFactory;
    }

    public function getById(int $entityTypeId): EntityTypeInterface
    {
        if (isset($this->cachedEntities[$entityTypeId])) {
            return $this->cachedEntities[$entityTypeId];
        }

        try {
            $entityTypeModel = $this->entityTypeRepository->getById($entityTypeId);
        } catch (NoSuchEntityException $exception) {
            $entityTypeModel = $this->entityTypeFactory->create();
        }

        return $this->cachedEntities[$entityTypeId] = $entityTypeModel;
    }
}
