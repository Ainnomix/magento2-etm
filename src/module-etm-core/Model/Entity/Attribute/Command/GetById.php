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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Command;

use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Ainnomix\EtmCore\Api\Data\AttributeInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as Resource;

class GetById implements GetByIdInterface
{

    /**
     * @var AttributeInterfaceFactory
     */
    protected $attributeFactory;

    /**
     * @var Resource
     */
    protected $resource;

    public function __construct(AttributeInterfaceFactory $attributeFactory, Resource $resource)
    {
        $this->attributeFactory = $attributeFactory;
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(int $attributeId): AttributeInterface
    {
        /** @var AttributeInterface $attribute */
        $attribute = $this->attributeFactory->create();
        $this->resource->load($attribute, $attributeId);

        if (!$attribute->getAttributeId()) {
            throw new NoSuchEntityException(
                __('Attribute entity does not exist.')
            );
        }

        return $attribute;
    }
}
