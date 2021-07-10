<?php
/*
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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\Entity;

use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context;
use Ainnomix\EtmCore\Api\Data\EntityInterfaceFactory;
use Ainnomix\EtmCore\Api\EntityRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class Index extends AbstractAction implements HttpGetActionInterface
{

    /**
     * @var EntityInterfaceFactory
     */
    private $entityFactory;

    /**
     * @var EntityRepositoryInterface
     */
    private $entityRepository;
    /**
     * @var CustomerInterfaceFactory
     */
    private $customerFactory;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    public function __construct(
        Action\Context $context,
        Context $typeContext,
        EntityInterfaceFactory $entityFactory,
        EntityRepositoryInterface $entityRepository,
        CustomerInterfaceFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository
    ) {
        parent::__construct($context, $typeContext);

        $this->entityFactory = $entityFactory;
        $this->entityRepository = $entityRepository;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
    }

    public function execute(): Page
    {
        $entityType = $this->getEntityType();

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $currentMenu = $this->aclIdProvider->get($entityType);
        $resultPage->setActiveMenu($currentMenu);

        $resultPage->getConfig()->getTitle()->prepend(__('Entity Type Manager'));
        $resultPage->getConfig()->getTitle()->prepend(
            __('Manage "%1" Entities', $entityType->getEntityTypeName())
        );

        return $resultPage;
    }
}
