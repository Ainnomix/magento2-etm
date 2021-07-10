<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Magento\Eav\Model\Entity\AbstractEntity;

class Entity extends AbstractEntity
{

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_entityIdField = 'entity_id';
    }
}
