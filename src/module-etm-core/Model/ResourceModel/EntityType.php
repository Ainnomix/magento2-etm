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

namespace Ainnomix\EtmCore\Model\ResourceModel;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Eav\Model\ResourceModel\Entity\Type as EavEntityType;

/**
 * Entity type resource model class
 *
 * @category Ainnomix
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class EntityType extends EavEntityType
{

    public function validateCodeExistence(EntityTypeInterface $entityType)
    {
        $connection = $this->getConnection();
        $select = $connection->select();

        $binds = ['entity_type_code' => $entityType->getEntityTypeCode()];

        $select->from($this->getMainTable())
            ->where('entity_type_code = :entity_type_code');

        if ($entityType->getEntityTypeId()) {
            $binds['entity_type_id'] = $entityType->getEntityTypeId();

            $select->where('entity_type_id != :entity_type_id');
        }

        $row = $connection->fetchRow($select, $binds);

        return empty($row);
    }
}
