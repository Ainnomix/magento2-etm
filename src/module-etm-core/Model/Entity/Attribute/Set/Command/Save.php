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
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set as Resource;
use Magento\Framework\Exception\CouldNotSaveException;

class Save implements SaveInterface
{

    /**
     * @var Resource
     */
    private $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(AttributeSetInterface $attributeSet): int
    {
        try {
            $this->resource->save($attributeSet);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save entity attribute set'), $exception);
        }

        return (int) $attributeSet->getAttributeSetId();
    }
}
