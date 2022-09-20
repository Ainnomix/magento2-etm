<?php
/**
 * This file is part of the Ainnomix Entity Type Manager package.
 *
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2022 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\ResourceModel\Entity\Type;

use Ainnomix\EtmCore\Model\Entity\Type;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Type as TypeAlias;
use Magento\Eav\Model\ResourceModel\Entity\Type\Collection as EavCollection;

class Collection extends EavCollection
{

    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init(Type::class, TypeAlias::class);
    }
}
