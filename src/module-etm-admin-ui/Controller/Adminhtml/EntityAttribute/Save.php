<?php
/**
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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttribute;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Cache\FrontendInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Ainnomix\EtmAdminUi\Helper\Entity\Attribute as AttributeHelper;
use Ainnomix\EtmAdminUi\Model\Entity\Attribute\CodeGenerator;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttribute\Context as AttributeContext;
use Magento\Eav\Model\Adminhtml\System\Config\Source\Inputtype\ValidatorFactory as InputValidatorFactory;
use Magento\Framework\Controller\ResultInterface;

class Save extends AbstractAction implements HttpPostActionInterface
{

    /**
     * @var CodeGenerator
     */
    protected $codeGenerator;

    /**
     * @var InputValidatorFactory
     */
    protected $inputValidatorFactory;

    /**
     * @var AttributeHelper
     */
    protected $attributeHelper;

    /**
     * @var FrontendInterface
     */
    protected $attributeLabelCache;

    public function __construct(
        Context $context,
        AttributeContext $attributeContext,
        CodeGenerator $codeGenerator,
        InputValidatorFactory $inputValidatorFactory,
        AttributeHelper $attributeHelper,
        FrontendInterface $attributeLabelCache
    ) {
        parent::__construct(
            $context,
            $attributeContext
        );

        $this->codeGenerator = $codeGenerator;
        $this->inputValidatorFactory = $inputValidatorFactory;
        $this->attributeHelper = $attributeHelper;
        $this->attributeLabelCache = $attributeLabelCache;
    }

    public function execute(): ResultInterface
    {
        $entityType = $this->getEntityType();
        $attribute = $this->getAttribute();

        $returnParams = [
            'entity_type_id' => $entityType->getEntityTypeId(),
            'id' => $attribute->getAttributeId()
        ];

        if ($attribute->getAttributeId() && $attribute->getEntityTypeId() != $entityType->getEntityTypeId()) {
            $this->messageManager->addErrorMessage(__('Requested attribute cannot be updated'));
            return $this->resultRedirectFactory->create()->setPath('etm/*/', $returnParams);
        }

        $attributeCode = $attribute->getAttributeId() ?
            $attribute->getAttributeCode() :
            $this->codeGenerator->generate($this->getRequest()->getParam('frontend_label')[0]);
        $attribute->setAttributeCode($attributeCode);

        $data = $this->getRequest()->getPostValue();

        if (isset($data['frontend_input'])) {
            $inputType = $this->inputValidatorFactory->create();
            if (!$inputType->isValid($data['frontend_input'])) {
                foreach ($inputType->getMessages() as $message) {
                    $this->messageManager->addErrorMessage($message);
                }
                return $this->resultRedirectFactory->create()->setPath('etm/*/', $returnParams);
            }
        }

        $data = $this->convertPresentationDataToInputType($data);

        if ($attribute->getAttributeId()) {
            $data['is_user_defined'] = $attribute->getIsUserDefined();
            $data['frontend_input'] = $data['frontend_input'] ?? $attribute->getFrontendInput();
        }

        if (!$attribute->getAttributeId()) {
            $data['source_model'] = $this->attributeHelper->getAttributeSourceModelByInputType(
                $data['frontend_input']
            );
            $data['backend_model'] = $this->attributeHelper->getAttributeBackendModelByInputType(
                $data['frontend_input']
            );

            $data['backend_type'] = $attribute->getBackendTypeByInput($data['frontend_input']);
            $attribute->setIsUserDefined(1);
        }

        $defaultValueField = $attribute->getDefaultValueByInput($data['frontend_input']);
        if ($defaultValueField) {
            $data['default_value'] = $this->getRequest()->getParam($defaultValueField);
        }

        $attribute->addData($data);

        try {
            $this->attributeRepository->save($attribute);
            $this->messageManager->addSuccessMessage(__('Attribute has been successfully saved'));

            $this->attributeLabelCache->clean();
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());

            return $this->resultRedirectFactory->create()->setPath('etm/*/', $returnParams);
        }

        return $this->resultRedirectFactory->create()
            ->setPath('etm/*/', ['entity_type_id' => $entityType->getEntityTypeId()]);
    }

    protected function convertPresentationDataToInputType(array $data) : array
    {
        if (!isset($data['frontend_input'])) {
            return $data;
        }

        if ($data['frontend_input'] === 'textarea') {
            $data['is_wysiwyg_enabled'] = 0;
        }

        if ($data['frontend_input'] === 'texteditor') {
            $data['is_wysiwyg_enabled'] = 1;
            $data['frontend_input'] = 'textarea';
        }

        return $data;
    }
}
