<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

/**
 * New entity type action class
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class NewAction extends Action implements HttpGetActionInterface
{

    /**
     * Execute controller action
     *
     * @return Forward
     */
    public function execute(): Forward
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultPage->forward('edit');
    }
}
