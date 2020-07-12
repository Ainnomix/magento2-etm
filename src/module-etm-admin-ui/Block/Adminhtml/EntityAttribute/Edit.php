<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttribute;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;

class Edit extends Container
{

    /**
     * Block group name
     *
     * @var string
     */
    protected $_blockGroup = 'Ainnomix_EtmAdminUi';

    /**
     * Block path
     *
     * @var string
     */
    protected $_controller = 'adminhtml_entityAttribute';

    /**
     * Get form action URL
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save', ['_current' => true]);
    }
}
