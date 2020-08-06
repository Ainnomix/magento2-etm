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

use Exception;
use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as ResourceModel;

class Save implements SaveInterface
{

    /**
     * @var ResourceModel
     */
    private $resource;

    public function __construct(ResourceModel $resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(AttributeInterface $attribute): int
    {
        try {
            $this->resource->save($attribute);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save entity attribute'), $exception);
        }

        return (int) $attribute->getAttributeId();
    }
}
