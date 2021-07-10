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

namespace Ainnomix\EtmCore\Model\ResourceModel\Entity\Attribute\Group;

use Ainnomix\EtmCore\Model\Entity\Attribute\Group;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group as ResourceModel;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\Collection as EavCollection;

class Collection extends EavCollection
{

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(
            Group::class,
            ResourceModel::class
        );
    }
}
