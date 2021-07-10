<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model;

use Ainnomix\EtmCore\Api\Data\EntityInterface;
use Magento\Framework\Model\AbstractModel;

class Entity extends AbstractModel implements EntityInterface
{

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Entity::class);
    }
}
