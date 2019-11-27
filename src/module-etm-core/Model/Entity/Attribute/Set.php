<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Attribute;

use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Magento\Eav\Model\Entity\Attribute\Set as EavAttributeSet;

class Set extends EavAttributeSet implements AttributeSetInterface
{

}
