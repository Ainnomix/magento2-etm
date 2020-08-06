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

use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group as Resource;

class Get implements GetInterface
{

    /**
     * @var AttributeGroupInterfaceFactory
     */
    private $groupFactory;

    /**
     * @var Resource
     */
    private $resource;

    public function __construct(AttributeGroupInterfaceFactory $groupFactory, Resource $resource)
    {
        $this->groupFactory = $groupFactory;
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(int $groupId): AttributeGroupInterface
    {
        /** @var AttributeGroupInterface $attributeGroup */
        $attributeGroup = $this->groupFactory->create();
        $this->resource->load($attributeGroup, $groupId);

        if (!$attributeGroup->getAttributeGroupId()) {
            throw new NoSuchEntityException(
                __('Attribute group does not exist.')
            );
        }

        return $attributeGroup;
    }
}
