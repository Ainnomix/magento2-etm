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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\Entity\Type;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

/**
 * New entity type action class
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class NewAction extends \Magento\Backend\App\Action implements HttpGetActionInterface
{

    /**
     * Execute controller action
     *
     * @return \Magento\Framework\Controller\Result\Forward
     */
    public function execute(): \Magento\Framework\Controller\Result\Forward
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultPage->forward('edit');
    }
}
