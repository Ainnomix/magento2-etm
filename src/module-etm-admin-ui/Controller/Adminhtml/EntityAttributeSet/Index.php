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
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\Page;

class Index extends AbstractAction implements HttpGetActionInterface
{

    /**
     * Execute controller action
     *
     * @return Page
     *
     * @throws NoSuchEntityException
     * @throws NotFoundException
     */
    public function execute(): Page
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $currentMenu = $this->nameProvider->getAttributeSetsNodeId($this->getEntityType());
        $resultPage->setActiveMenu($currentMenu);

        $entityType = $this->getEntityType();

        $resultPage->getConfig()->getTitle()->prepend(__('Entity Type Manager'));
        $resultPage->getConfig()->getTitle()->prepend(
            __('Manage "%1" Attribute Sets', $entityType->getEntityTypeName())
        );

        return $resultPage;
    }
}
