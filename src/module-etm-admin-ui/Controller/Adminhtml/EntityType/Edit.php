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

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType\Initialization\Helper;

/**
 * Edit entity type action class
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Edit extends AbstractAction implements HttpGetActionInterface
{

    /**
     * Entity type instance initialization helper
     *
     * @var Helper
     */
    protected $initializationHelper;

    /**
     * Edit constructor
     *
     * @param Context $context
     * @param Helper $initializationHelper
     */
    public function __construct(Context $context, Helper $initializationHelper)
    {
        parent::__construct($context);

        $this->initializationHelper = $initializationHelper;
    }

    /**
     * Execute controller action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        try {
            $resultPage = $this->renderResult();
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Requested entity type does not exist.'));

            $resultPage = $this->resultRedirectFactory->create();
            $resultPage->setPath('*/*/');
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());

            $resultPage = $this->resultRedirectFactory->create();
            $resultPage->setPath('*/*/');
        }

        return $resultPage;
    }

    /**
     * @return ResultInterface
     *
     * @throws NoSuchEntityException
     */
    private function renderResult()
    {
        $entityTypeId = (int) $this->getRequest()->getParam('id');

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $entityType = $this->initializationHelper->getById($entityTypeId);

        $resultPage->setActiveMenu('Ainnomix_EtmAdminhtml::management_index');
        $resultPage->getConfig()->getTitle()->prepend(__('Entity Type Manager'));

        if ($entityType->getEntityTypeId()) {
            $resultPage->getConfig()->getTitle()->prepend(__('Edit "%1" type', $entityType->getEntityTypeCode()));
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('Create Entity Type'));
        }

        return $resultPage;
    }
}
