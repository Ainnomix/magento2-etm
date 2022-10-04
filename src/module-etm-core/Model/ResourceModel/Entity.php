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

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Magento\Eav\Model\Entity\AbstractEntity;

class Entity extends AbstractEntity
{

    /**
     * TODO: [I-1] Workaround, as we cannot set entity type object into entity instance and cannot set it statically,
     * as this class is universal for all types.
     *
     * @var string
     */
    protected $_entityIdField = \Magento\Eav\Model\Entity::DEFAULT_ENTITY_ID_FIELD;

    /**
     * @var string
     */
//    protected $linkIdField = \Magento\Eav\Model\Entity::DEFAULT_ENTITY_ID_FIELD;

    /**
     * @inheritDoc
     */
    protected function _getDefaultAttributes(): array
    {
        return ['attribute_set_id', 'created_at', 'updated_at'];
    }
}
