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

namespace Ainnomix\EtmAdminUi\Ui\Component\Listing\EntityAttribute;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as ViewDataProvider;

class DataProvider extends ViewDataProvider
{

    /**
     * Prepare update UI url
     *
     * @return void
     */
    protected function prepareUpdateUrl() :void
    {
        parent::prepareUpdateUrl();

        $paramValue = $this->request->getParam('entity_type_id');

        $this->data['config']['update_url'] = sprintf(
            '%s%s/%s/',
            $this->data['config']['update_url'],
            'entity_type_id',
            $paramValue
        );
    }
}
