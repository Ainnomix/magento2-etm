<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttributeSet\Edit\Toolbar;

use Magento\Backend\Block\Widget\Button;

class BackButton extends Button
{

    /**
     * Configure button class
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function _construct(): void
    {
        $url = $this->getUrl(
            'etm/*/',
            ['entity_type_id' => $this->getRequest()->getParam('entity_type_id')]
        );

        $this->addData(
            [
                'label' => __('Back'),
                'onclick' => 'setLocation(\'' . $url . '\')',
                'class' => 'back'
            ]
        );

        parent::_construct();
    }
}
