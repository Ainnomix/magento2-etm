<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_EtmAdminhtml
 * @package   Ainnomix\EtmAdminhtml
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType;

use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;

/**
 * Delete entity type action class
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Delete extends Action implements HttpGetActionInterface
{

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    public function __construct(
        Action\Context $context,
        EntityTypeRepositoryInterface $entityTypeRepository
    ) {
        parent::__construct($context);

        $this->entityTypeRepository = $entityTypeRepository;
    }

    public function execute(): Redirect
    {
        $entityTypeId = (int) $this->getRequest()->getParam('id');

        try {
            $this->entityTypeRepository->deleteById($entityTypeId);
            $this->messageManager->addSuccessMessage(__('The entity type has been successfully deleted'));
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Requested entity type does not exist.'));
        } catch (CouldNotDeleteException $exception) {
            $this->messageManager->addErrorMessage(__('Could not delete entity type does not exist.'));
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }
}
