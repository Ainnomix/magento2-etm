<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;
use Ainnomix\EtmAdminUi\Model\Acl\TypeResource\ProviderInterface;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context as TypeContext;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;

abstract class EntityType extends Action
{

    const TYPE_ID_PARAM = 'entity_type_id';

    /**
     * @var EntityTypeProvider
     */
    protected $entityTypeProvider;

    /**
     * @var ProviderInterface
     */
    protected $aclIdProvider;

    /**
     * EntityType constructor
     *
     * @param Action\Context $context
     * @param Context        $typeContext
     */
    public function __construct(
        Action\Context $context,
        TypeContext $typeContext
    ) {
        parent::__construct($context);

        $this->entityTypeProvider = $typeContext->getEntityTypeProvider();
        $this->aclIdProvider = $typeContext->getAclIdProvider();
    }

    /**
     * Retrieve current entity type instance
     *
     * @return EntityTypeInterface
     *
     * @throws NoSuchEntityException
     */
    protected function getEntityType(): EntityTypeInterface
    {
        $typeId = (int) $this->getRequest()->getParam(static::TYPE_ID_PARAM);

        return $this->entityTypeProvider->get($typeId);
    }

    /**
     * {@inheritDoc}
     *
     * @throws NotFoundException
     */
    protected function _isAllowed()
    {
        try {
            $typeInstance = $this->getEntityType();
        } catch (NoSuchEntityException $exception) {
            throw new NotFoundException(__('No such entity type'), $exception);
        }

        return $this->_authorization->isAllowed(
            $this->aclIdProvider->get($typeInstance)
        );
    }
}
