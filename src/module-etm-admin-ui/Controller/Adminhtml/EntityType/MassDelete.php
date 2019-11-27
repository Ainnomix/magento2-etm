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
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\Result\Redirect;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType\CollectionFactory;

/**
 * Delete multiple entity types action class
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class MassDelete extends AbstractAction
{

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        EntityTypeRepositoryInterface $entityTypeRepository
    ) {
        parent::__construct($context);

        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->entityTypeRepository = $entityTypeRepository;
    }

    public function execute(): Redirect
    {
        try {
            $entitiesDeleted = 0;

            $collection = $this->filter->getCollection($this->collectionFactory->create());
            foreach ($collection->getAllIds() as $entityId) {
                $this->entityTypeRepository->deleteById((int) $entityId);
                $entitiesDeleted++;
            }

            if ($entitiesDeleted) {
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were deleted.', $entitiesDeleted));
            }
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }
}
