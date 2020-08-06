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
use Ainnomix\EtmCore\Api\Data\AttributeInterfaceFactory;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as Resource;

class Get implements GetInterface
{

    /**
     * @var AttributeInterfaceFactory
     */
    protected $attributeFactory;

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    /**
     * @var Resource
     */
    protected $resource;

    public function __construct(
        AttributeInterfaceFactory $attributeFactory,
        EntityTypeRepositoryInterface $entityTypeRepository,
        Resource $resource
    ) {
        $this->attributeFactory = $attributeFactory;
        $this->entityTypeRepository = $entityTypeRepository;
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(string $entityTypeCode, string $attributeCode): AttributeInterface
    {
        $entityType = $this->entityTypeRepository->get($entityTypeCode);
        /** @var AttributeInterface $attribute */
        $attribute = $this->attributeFactory->create();

        $this->resource->loadByCode($attribute, $entityType->getEntityTypeId(), $attributeCode);

        if (!$attribute->getAttributeId()) {
            throw new NoSuchEntityException(
                __('Attribute entity does not exist.')
            );
        }

        return $attribute;
    }
}
