<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_Etm
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\Entity\Type;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
//use Ainnomix\EtmAdminhtml\Model\Entity\Type\TypeManagement;

/**
 * Edit entity type action class
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{

    /**
     * @var TypeManagement
     */
//    private $typeManagement;

//    public function __construct(\Magento\Backend\App\Action\Context $context, TypeManagement $typeManagement)
//    {
//        parent::__construct($context);
//
//        $this->typeManagement = $typeManagement;
//    }

    public function execute(): \Magento\Framework\View\Result\Page
    {
        $entityTypeId = $this->getRequest()->getParam('id');
//        $entityType = $this->typeManagement->getById((int) $entityTypeId);

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Ainnomix_EtmAdminhtml::management_index');
        $resultPage->getConfig()->getTitle()->prepend(__('Entity Type Manager'));

//        if ($entityType->getEntityTypeId()) {
//            $resultPage->getConfig()->getTitle()->prepend(__('Edit %1', $entityType->getEntityTypeCode()));
//        } else {
//            $resultPage->getConfig()->getTitle()->prepend(__('Create entity type'));
//        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
