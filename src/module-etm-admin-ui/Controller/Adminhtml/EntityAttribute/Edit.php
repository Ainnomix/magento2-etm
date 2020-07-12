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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttribute;

use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends AbstractAction implements HttpGetActionInterface
{

    /**
     * Execute controller action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        try {
            $attribute = $this->getAttribute();
        } catch (NoSuchEntityException $exception) {
            $this->getMessageManager()->addErrorMessage('No such attribute entity');

            return $this->resultRedirectFactory->create()->setPath(
                'etm/*/index',
                ['entity_type_id' => $this->getEntityType()->getEntityTypeId()]
            );
        }

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $entityType = $this->getEntityType();

        $currentMenu = $this->aclIdProvider->get($entityType);
        $resultPage->setActiveMenu($currentMenu);

        $resultPage->getConfig()->getTitle()->prepend(
            __('Manage "%1" Attributes', $entityType->getEntityTypeName())
        );
        $resultPage->getConfig()->getTitle()->prepend(
            $attribute->getAttributeId() ?
                __('Edit "%1" Attribute', $attribute->getAttributeCode()) :
                __('New Attribute')
        );

        return $resultPage;
    }
}
