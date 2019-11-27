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

use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType\Initialization\Helper;

/**
 * Save Entity type action class
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Save extends AbstractAction implements HttpPostActionInterface
{

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var Helper
     */
    protected $initializationHelper;

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    public function __construct(
        Context $context,
        DataObjectHelper $dataObjectHelper,
        Helper $initializationHelper,
        EntityTypeRepositoryInterface $entityTypeRepository
    ) {
        parent::__construct($context);

        $this->dataObjectHelper = $dataObjectHelper;
        $this->initializationHelper = $initializationHelper;
        $this->entityTypeRepository = $entityTypeRepository;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $requestData = $this->getRequest()->getParams();

        if (!$this->getRequest()->isPost() || empty($requestData['general'])) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));
            $resultRedirect->setPath('*/*/new');
            return $resultRedirect;
        }

        $entityTypeId = (int) $requestData['general'][EntityTypeInterface::ENTITY_TYPE_ID] ?? 0;

        try {
            $entityType = $this->initializationHelper->getById($entityTypeId);
            $this->dataObjectHelper->populateWithArray(
                $entityType,
                $this->filterRequestData($requestData['general']),
                EntityTypeInterface::class
            );
            $entityTypeId = $this->entityTypeRepository->save($entityType);
            $this->processRedirectAfterSuccessSave($resultRedirect, $entityTypeId);
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Requested entity type does not exist.'));
            $this->processRedirectAfterFailureSave($resultRedirect, $entityTypeId);
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $this->processRedirectAfterFailureSave($resultRedirect, $entityTypeId);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Could not save Entity type.'));
            $this->processRedirectAfterFailureSave($resultRedirect, $entityTypeId);
        }

        return $resultRedirect;
    }

    private function filterRequestData(array $data): array
    {
        return array_filter($data, function ($value) {
            return !empty($value);
        });
    }

    private function processRedirectAfterSuccessSave(Redirect $resultRedirect, int $typeId)
    {
        if ($this->getRequest()->getParam('back')) {
            $resultRedirect->setPath('*/*/edit', [
                'id' => $typeId,
                '_current' => true,
            ]);
        } elseif ($this->getRequest()->getParam('redirect_to_new')) {
            $resultRedirect->setPath('*/*/new', [
                '_current' => true,
            ]);
        } else {
            $resultRedirect->setPath('*/*/');
        }
    }

    private function processRedirectAfterFailureSave(Redirect $resultRedirect, int $typeId = null)
    {
        if (null === $typeId) {
            $resultRedirect->setPath('*/*/new');
        } else {
            $resultRedirect->setPath('*/*/edit', [
                EntityTypeInterface::ENTITY_TYPE_ID => $typeId,
                '_current' => true,
            ]);
        }
    }
}
