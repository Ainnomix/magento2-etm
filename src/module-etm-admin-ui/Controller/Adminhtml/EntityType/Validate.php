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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\Entity\Type;

use Magento\Backend\App\Action;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Ainnomix\EtmApi\Api\Data\EntityTypeInterface;
use Ainnomix\EtmAdminUi\Model\Model\Entity\Type\Validator;
use Ainnomix\EtmApi\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmApi\Api\EntityTypeRepositoryInterface;

/**
 * Entity type validation action class
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Validate extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var LayoutFactory
     */
    private $layoutFactory;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var EntityTypeInterfaceFactory
     */
    private $entityTypeFactory;

    /**
     * @var EntityTypeRepositoryInterface
     */
    private $entityTypeRepository;

    public function __construct(
        Action\Context $context,
        Validator $validator,
        EntityTypeInterfaceFactory $entityTypeFactory,
        EntityTypeRepositoryInterface $entityTypeRepository,
        LayoutFactory $layoutFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        parent::__construct($context);

        $this->validator = $validator;
        $this->layoutFactory = $layoutFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->entityTypeFactory = $entityTypeFactory;
        $this->entityTypeRepository = $entityTypeRepository;
    }

    /**
     * Execute controller action
     *
     * @return Json
     */
    public function execute(): Json
    {
        $response = new \Magento\Framework\DataObject();
        $response->setError(false);

        $requestData = $this->getRequest()->getParams();

        if (!$this->getRequest()->isPost() || empty($requestData['general'])) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));
            $layout = $this->layoutFactory->create();
            $layout->initMessages();
            $response->setError(true);
            $response->setHtmlMessage($layout->getMessagesBlock()->getGroupedHtml());
        }

        $entityTypeId = !empty($requestData['general'][EntityTypeInterface::ENTITY_TYPE_ID])
            ? (int) $requestData['general'][EntityTypeInterface::ENTITY_TYPE_ID]
            : null;

        try {
            $entityType = $this->getEntityInstance($entityTypeId);
            $this->dataObjectHelper->populateWithArray(
                $entityType,
                $this->filterRequestData($requestData['general']),
                EntityTypeInterface::class
            );

            if (!$this->validator->isValid($entityType)) {
                $response->setError(true);
                $response->setMessages($this->validator->getMessages());
            }
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $layout = $this->layoutFactory->create();
            $layout->initMessages();
            $response->setError(true);
            $response->setHtmlMessage($layout->getMessagesBlock()->getGroupedHtml());
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($response);
    }

    private function getEntityInstance(?int $entityTypeId): EntityTypeInterface
    {
        if (null === $entityTypeId) {
            $entityType = $this->entityTypeFactory->create();
        } else {
            $entityType = $this->entityTypeRepository->getById($entityTypeId);
        }
        return $entityType;
    }

    private function filterRequestData(array $data): array
    {
        return array_filter($data, function ($value) {
            return !empty($value);
        });
    }
}
