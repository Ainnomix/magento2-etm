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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttributeSet;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;

class Index extends AbstractAction implements HttpGetActionInterface
{

    /**
     * Execute controller action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $entityType = $this->getEntityType();
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $currentMenu = $this->aclIdProvider->get($entityType);
        $resultPage->setActiveMenu($currentMenu);

        $resultPage->getConfig()->getTitle()->prepend(__('Entity Type Manager'));
        $resultPage->getConfig()->getTitle()->prepend(
            __('Manage "%1" Attribute Sets', $entityType->getEntityTypeName())
        );

        return $resultPage;
    }
}
