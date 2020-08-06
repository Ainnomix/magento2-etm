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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Group\Command;

use Exception;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group as Resource;

class DeleteById implements DeleteByIdInterface
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
    public function execute(int $groupId): void
    {
        /** @var AttributeGroupInterface $attributeGroup */
        $attributeGroup = $this->attributeGroupFactory->create();
        $this->resource->load($attributeGroup, $groupId);

        if (!$attributeGroup->getAttributeGroupId()) {
            throw new NoSuchEntityException(
                __('There is no attribute group with id "%fieldValue"', ['fieldValue' => $groupId])
            );
        }

        try {
            $this->resource->delete($attributeGroup);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete attribute group'), $exception);
        }
    }
}
