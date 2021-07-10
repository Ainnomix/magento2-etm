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

namespace Ainnomix\EtmCore\Model\ResourceModel\Entity\Attribute;

use Ainnomix\EtmCore\Model\Entity\Attribute;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as ResourceModel;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as EavCollection;

class Collection extends EavCollection
{

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(
            Attribute::class,
            ResourceModel::class
        );
    }
}
