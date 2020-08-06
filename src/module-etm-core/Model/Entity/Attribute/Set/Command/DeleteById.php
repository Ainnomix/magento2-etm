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

namespace Ainnomix\EtmCore\Model\Entity\Attribute\Set\Command;

use Exception;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set as Resource;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class DeleteById implements DeleteByIdInterface
{

    /**
     * @var AttributeSetInterfaceFactory
     */
    protected $attributeSetFactory;

    /**
     * @var Resource
     */
    protected $resource;

    public function __construct(AttributeSetInterfaceFactory $attributeSetFactory, Resource $resource)
    {
        $this->attributeSetFactory = $attributeSetFactory;
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(int $setId): void
    {
        $attributeSet = $this->attributeSetFactory->create();
        $this->resource->load($attributeSet, $setId);

        if (null === $attributeSet->getAttributeSetId()) {
            throw new NoSuchEntityException(
                __(
                    'There is no attribute set with "%fieldValue" for "%fieldName". Verify and try again.',
                    [
                        'fieldName' => 'attribute_set_id',
                        'fieldValue' => $setId
                    ]
                )
            );
        }

        try {
            $this->resource->delete($attributeSet);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete attribute set'), $exception);
        }
    }
}
