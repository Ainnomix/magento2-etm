<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_EtmAdminhtml
 * @package   Ainnomix\EtmAdminhtml
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
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
use Magento\Framework\Validator\DataObject as Validator;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Model\EntityType\ValidatorFactory;

/**
 * Entity type validation action class
 *
 * @author Roman Tomchak <romantomchak@gmail.com>
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
     * @var Validator
     */
    private $validator;

    public function __construct(
        Context $context,
        DataObjectHelper $dataObjectHelper,
        EntityTypeInterfaceFactory $entityTypeFactory,
        ValidatorFactory $validatorFactory
    ) {
        parent::__construct($context);

        $this->dataObjectHelper = $dataObjectHelper;
        $this->entityTypeFactory = $entityTypeFactory;
        $this->validator = $validatorFactory->create();
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

            if (!$this->validator->isValid($entityType)) {
                $response->setError(true);
                $response->setMessages($this->validator->getMessages());
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
