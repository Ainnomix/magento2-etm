<?php
declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\Entity;

use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context as TypeContext;
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

        $customer = $this->customerFactory->create();
        $customer->setEmail('bebe@example.com');
        $customer->setFirstname('Bebe');
        $customer->setLastname('Bebe');
        $this->customerRepository->save($customer);

        $entity = $this->entityFactory->create();
        $entity->setBebe('Bebe Value');
        $entityId = $this->entityRepository->save($entityType, $entity);


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
