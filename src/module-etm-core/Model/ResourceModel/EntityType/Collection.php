<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_Etm
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\ResourceModel\EntityType;

use Ainnomix\EtmCore\Model\EntityType;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as ResourceEntityType;
use Magento\Eav\Model\ResourceModel\Entity\Type\Collection as EavCollection;

/**
 * Entity type collection class
 *
 * @category Ainnomix
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Collection extends EavCollection
{

    /**
     * Configure collection
     */
    protected function _construct(): void
    {
        $this->_init(EntityType::class, ResourceEntityType::class);

        $this->_idFieldName = 'entity_type_id';
    }
}
