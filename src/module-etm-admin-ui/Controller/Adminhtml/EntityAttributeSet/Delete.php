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

use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Ainnomix\EtmAdminUi\Model\Acl\Resource\NameProvider;
use Ainnomix\EtmAdminUi\Model\Ui\AttributeSetProvider;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;

class Delete extends AbstractAction implements HttpGetActionInterface
{

    /**
     * @var AttributeSetRepositoryInterface
     */
    protected $attributeSetRepository;

    /**
     * Delete constructor
     *
     * @param Action\Context                  $context
     * @param EntityTypeProvider              $entityTypeProvider
     * @param AttributeSetProvider            $attributeSetProvider
     * @param NameProvider                    $nameProvider
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     */
    public function __construct(
        Action\Context $context,
        EntityTypeProvider $entityTypeProvider,
        AttributeSetProvider $attributeSetProvider,
        NameProvider $nameProvider,
        AttributeSetRepositoryInterface $attributeSetRepository
    ) {
        parent::__construct(
            $context,
            $entityTypeProvider,
            $attributeSetProvider,
            $nameProvider
        );

        $this->attributeSetRepository = $attributeSetRepository;
    }

    /**
     * Execute controller action
     *
     * @return Redirect
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create()
            ->setPath('etm/*/index', ['entity_type_id' => $this->getEntityType()->getEntityTypeId()]);

        try {
            $attributeSet = $this->getAttributeSet();
            if (!$attributeSet->getAttributeSetId()) {
                throw new LocalizedException(__("There is no such attribute set"));
            }

            $this->attributeSetRepository->deleteById((int) $attributeSet->getAttributeSetId());
            $this->getMessageManager()->addSuccessMessage(__('Attribute set has been deleted'));
        } catch (Exception $exception) {
            $this->getMessageManager()->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect;
    }
}
