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
use Magento\Framework\DataObject;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Model\EntityTypeValidatorInterface;

/**
 * Entity type validation action class
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Validate extends AbstractAction implements HttpPostActionInterface
{

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var EntityTypeInterfaceFactory
     */
    private $entityTypeFactory;

    /**
     * @var EntityTypeValidatorInterface
     */
    private $validator;

    public function __construct(
        Context $context,
        DataObjectHelper $dataObjectHelper,
        EntityTypeInterfaceFactory $entityTypeFactory,
        EntityTypeValidatorInterface $validator
    ) {
        parent::__construct($context);

        $this->dataObjectHelper = $dataObjectHelper;
        $this->entityTypeFactory = $entityTypeFactory;
        $this->validator = $validator;
    }

    /**
     * Execute controller action
     *
     * @return Json
     */
    public function execute(): Json
    {
        $response = new DataObject();
        $response->setError(false);

        $requestData = $this->getRequest()->getParams();

        try {
            if (!$this->getRequest()->isPost() || empty($requestData['general'])) {
                throw new Exception((string) __('Wrong request.'));
            }

            $entityType = $this->entityTypeFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $entityType,
                $this->filterRequestData($requestData['general']),
                EntityTypeInterface::class
            );

            $validationResult = $this->validator->validate($entityType);
            if (!$validationResult->isValid()) {
                $response->setError(true);
                $response->setMessages($validationResult->getErrors());
            }
        } catch (Exception $exception) {
            $response->setError(true);
            $response->setMessages([$exception->getMessage()]);
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($response);
    }

    private function filterRequestData(array $data): array
    {
        return array_filter($data, function ($value) {
            return !empty($value);
        });
    }
}
