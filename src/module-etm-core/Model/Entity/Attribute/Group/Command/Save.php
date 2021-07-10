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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Group\Command;

use Exception;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group as Resource;

class Save implements SaveInterface
{

    /**
     * @var AttributeGroupInterfaceFactory
     */
    private $attributeGroupFactory;

    /**
     * @var Resource
     */
    private $resource;

    public function __construct(AttributeGroupInterfaceFactory $attributeGroupFactory, Resource $resource)
    {
        $this->attributeGroupFactory = $attributeGroupFactory;
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(AttributeGroupInterface $attributeGroup): int
    {
        if ($attributeGroup->getAttributeGroupId()) {
            /** @var AttributeGroupInterface $existingGroup */
            $existingGroup = $this->attributeGroupFactory->create();
            $this->resource->load($existingGroup, (int) $attributeGroup->getAttributeGroupId());

            if (!$existingGroup->getAttributeGroupId()) {
                throw new NoSuchEntityException(
                    __(
                        'There is no attribute group with id "%fieldValue"',
                        ['fieldValue' => $attributeGroup->getAttributeGroupId()]
                    )
                );
            }

            if ($existingGroup->getAttributeSetId() != $attributeGroup->getAttributeSetId()) {
                throw new StateException(
                    __("The attribute group doesn't belong to the provided attribute set.")
                );
            }
        }

        try {
            $this->resource->save($attributeGroup);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save entity attribute group'), $exception);
        }

        return (int) $attributeGroup->getAttributeGroupId();
    }
}
