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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Set\Command;

use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set as Resource;
use Magento\Framework\Exception\NoSuchEntityException;

class Get implements GetInterface
{

    /**
     * @var AttributeSetInterfaceFactory
     */
    private $attributeSetFactory;

    /**
     * @var Resource
     */
    private $resource;

    public function __construct(AttributeSetInterfaceFactory $attributeSetFactory, Resource $resource)
    {
        $this->attributeSetFactory = $attributeSetFactory;
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(int $attributeSetId): AttributeSetInterface
    {
        /** @var AttributeSetInterface $attributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $this->resource->load($attributeSet, $attributeSetId);

        if (!$attributeSet->getAttributeSetId()) {
            throw new NoSuchEntityException(
                __('Attribute set does not exist.')
            );
        }

        return $attributeSet;
    }
}
