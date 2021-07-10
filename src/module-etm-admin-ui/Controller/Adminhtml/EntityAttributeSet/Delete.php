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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttributeSet;

use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\NoSuchEntityException;
use Ainnomix\EtmAdminUi\Model\Ui\AttributeSetProvider;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context;

class Delete extends AbstractAction implements HttpPostActionInterface
{

    /**
     * @var AttributeSetRepositoryInterface
     */
    protected $attributeSetRepository;

    /**
     * Delete constructor
     *
     * @param Action\Context                  $context
     * @param Context                         $typeContext
     * @param AttributeSetProvider            $attributeSetProvider
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     */
    public function __construct(
        Action\Context $context,
        Context $typeContext,
        AttributeSetProvider $attributeSetProvider,
        AttributeSetRepositoryInterface $attributeSetRepository
    ) {
        parent::__construct(
            $context,
            $typeContext,
            $attributeSetProvider
        );

        $this->attributeSetRepository = $attributeSetRepository;
    }

    /**
     * Execute controller action
     *
     * @return Redirect
     *
     * @throws NoSuchEntityException
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create()
            ->setPath('etm/*/index', ['entity_type_id' => $this->getEntityType()->getEntityTypeId()]);

        try {
            $attributeSet = $this->getAttributeSet();

            $this->attributeSetRepository->deleteById((int)$attributeSet->getAttributeSetId());
            $this->getMessageManager()->addSuccessMessage(__('Attribute set has been deleted'));
        } catch (NoSuchEntityException $exception) {
            $this->getMessageManager()->addErrorMessage(__('No such attribute set entity'));
        } catch (Exception $exception) {
            $this->getMessageManager()->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect;
    }
}
