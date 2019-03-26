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

namespace Ainnomix\EtmCore\Model\ResourceModel\Entity\Type;

/**
 * Entity type collection class
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmCore
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Collection extends \Magento\Eav\Model\ResourceModel\Entity\Type\Collection
{

    /**
     * Configure collection
     */
    protected function _construct(): void
    {
        $this->_init(
            \Ainnomix\EtmCore\Model\Entity\Type::class,
            \Ainnomix\EtmCore\Model\ResourceModel\Entity\Type::class
        );
    }
}
