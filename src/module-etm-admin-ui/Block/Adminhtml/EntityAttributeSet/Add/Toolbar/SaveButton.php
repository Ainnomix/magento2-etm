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

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttributeSet\Add\Toolbar;

use Magento\Backend\Block\Widget\Button;

class SaveButton extends Button
{

    /**
     * Configure button class
     */
    public function _construct(): void
    {
        $this->addData(
            [
                'label' => __('Save'),
                'class' => 'save primary save-attribute-set',
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'save', 'target' => '#set-prop-form']],
                ]
            ]
        );

        parent::_construct();
    }
}
