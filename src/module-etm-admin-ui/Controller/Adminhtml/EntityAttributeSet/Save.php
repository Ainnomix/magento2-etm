<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttributeSet;

use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context;
use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Ainnomix\EtmAdminUi\Model\Ui\AttributeSetProvider;
use Ainnomix\EtmAdminUi\Model\Acl\Resource\NameProvider;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\Serialize\Serializer\Json as JsonHelper;

class Save extends AbstractAction implements HttpPostActionInterface
{

    /**
     * @var AttributeSetInterfaceFactory
     */
    private $attributeSetFactory;

    /**
     * @var AttributeSetRepositoryInterface
     */
    private $attributeSetRepository;

    /**
     * @var FilterManager
     */
    private $filterManager;

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    /**
     * @var LayoutFactory
     */
    private $layoutFactory;

    public function __construct(
        Action\Context $context,
        Context $typeContext,
        AttributeSetProvider $attributeSetProvider,
        AttributeSetInterfaceFactory $attributeSetFactory,
        AttributeSetRepositoryInterface $attributeSetRepository,
        FilterManager $filterManager,
        JsonHelper $jsonHelper,
        LayoutFactory $layoutFactory
    ) {
        parent::__construct(
            $context,
            $typeContext,
            $attributeSetProvider
        );

        $this->attributeSetFactory = $attributeSetFactory;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->filterManager = $filterManager;
        $this->jsonHelper = $jsonHelper;
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * Execute controller action
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $entityType = $this->getEntityType();

        $attributeSetId = $this->getRequest()->getParam('id', false);

        $hasError = false;

        $attributeSet = $this->attributeSetFactory->create();
        $attributeSet->setEntityTypeId($entityType->getEntityTypeId());

        try {
            if (false === $attributeSetId) {
                $attributeSetName = $this->filterManager->stripTags(
                    $this->getRequest()->getParam('attribute_set_name')
                );
                $attributeSet->setAttributeSetName(trim($attributeSetName));
            }

            if (false !== $attributeSetId) {
                $attributeSet = $this->attributeSetRepository->get((int) $attributeSetId);

                $data = $this->jsonHelper->unserialize($this->getRequest()->getPost('data'));
                $data['attribute_set_name'] = $this->filterManager->stripTags($data['attribute_set_name']);

                $attributeSet->organizeData($data);
            }

            $attributeSet->validate();
            if (false === $attributeSetId) {
                $this->attributeSetRepository->save($attributeSet);
                $attributeSet->initFromSkeleton($this->getRequest()->getParam('skeleton_set'));
            }

            $this->attributeSetRepository->save($attributeSet);
            $this->messageManager->addSuccessMessage(__('Attribute Set has been saved'));
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $hasError = true;
        }

        return $this->createResponse($attributeSet, $hasError, false === $attributeSetId);
    }

    private function createResponse(AttributeSetInterface $attributeSet, bool $hasError, bool $isNewSet)
    {
        if ($isNewSet) {
            return $this->createNewSetResponse($attributeSet, $hasError);
        }

        return $this->createSetResponse($hasError);
    }

    private function createNewSetResponse(AttributeSetInterface $attributeSet, bool $hasError)
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('etm/*/index', ['_current' => true]);

        if ($this->getRequest()->getParam('back') == 'edit' && !$hasError) {
            $resultRedirect->setPath(
                'etm/*/edit',
                ['id' => $attributeSet->getAttributeSetId(), '_current' => true]
            );
        }

        if ($this->getRequest()->getParam('redirect_to_new') && !$hasError) {
            $resultRedirect->setPath(
                'etm/*/new',
                ['_current' => true]
            );
        }

        return $resultRedirect;
    }

    private function createSetResponse(bool $hasError)
    {
        $response = [];
        $response['error'] = 0;
        $entityTypeId = (int) $this->getRequest()->getParam('entity_type_id');
        $response['url'] = $this->getUrl('etm/*/', ['entity_type_id' => $entityTypeId]);

        if ($hasError) {
            $layout = $this->layoutFactory->create();
            $layout->initMessages();
            $response['error'] = 1;
            $response['message'] = $layout->getMessagesBlock()->getGroupedHtml();
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_JSON)
            ->setData($response);
    }
}
