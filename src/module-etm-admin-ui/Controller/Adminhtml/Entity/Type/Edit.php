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

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\Entity\Type\Initialization\Helper;

/**
 * Edit entity type action class
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
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
     * @param Action\Context $context
     * @param Helper $initializationHelper
     */
    public function __construct(Action\Context $context, Helper $initializationHelper)
    {
        parent::__construct($context);

        $this->initializationHelper = $initializationHelper;
    }

    /**
     * Execute controller action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute(): \Magento\Framework\View\Result\Page
    {
        $entityTypeId = (int) $this->getRequest()->getParam('id');
        $entityType = $this->initializationHelper->getById($entityTypeId);

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Ainnomix_EtmAdminhtml::management_index');
        $resultPage->getConfig()->getTitle()->prepend(__('Entity Type Manager'));

        if ($entityType->getEntityTypeId()) {
            $resultPage->getConfig()->getTitle()->prepend(__('Edit "%1" type', $entityType->getEntityTypeCode()));
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('Create Entity type'));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
