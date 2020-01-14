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

use Magento\Backend\App\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmAdminUi\Model\Acl\Resource\NameProvider;
use Ainnomix\EtmAdminUi\Model\Ui\AttributeSetProvider;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

abstract class AbstractAction extends Action
{

    /**
     * @var NameProvider
     */
    protected $nameProvider;

    /**
     * @var EntityTypeProvider
     */
    protected $entityTypeProvider;

    /**
     * @var AttributeSetProvider
     */
    protected $attributeSetProvider;

    /**
     * AbstractAction constructor
     *
     * @param Action\Context       $context
     * @param EntityTypeProvider   $entityTypeProvider
     * @param AttributeSetProvider $attributeSetProvider
     * @param NameProvider         $nameProvider
     */
    public function __construct(
        Action\Context $context,
        EntityTypeProvider $entityTypeProvider,
        AttributeSetProvider $attributeSetProvider,
        NameProvider $nameProvider
    ) {
        parent::__construct($context);

        $this->entityTypeProvider = $entityTypeProvider;
        $this->attributeSetProvider = $attributeSetProvider;
        $this->nameProvider = $nameProvider;
    }

    /**
     * Retrieve current entity type instance
     *
     * @return EntityTypeInterface
     *
     * @throws NoSuchEntityException
     * @throws NotFoundException
     */
    protected function getEntityType(): EntityTypeInterface
    {
        $entityTypeId = (int) $this->getRequest()->getParam('entity_type_id');
        if (0 === $entityTypeId) {
            throw new NotFoundException(__('Requested entity type no longer exists'));
        }

        return $this->entityTypeProvider->get($entityTypeId);
    }

    /**
     * Retrieve current attribute set instance
     *
     * @return AttributeSetInterface
     *
     * @throws NotFoundException
     * @throws NoSuchEntityException
     */
    protected function getAttributeSet(): AttributeSetInterface
    {
        $attributeSetId = (int) $this->getRequest()->getParam('id');

        return $this->attributeSetProvider->get($this->getEntityType(), $attributeSetId);
    }

    /**
     * Check if user is allowed
     *
     * @return bool
     *
     * @throws NotFoundException
     * @throws NoSuchEntityException
     */
    protected function _isAllowed()
    {
        $aclResource = $this->nameProvider->getAttributeSetsNodeId($this->getEntityType());

        return $this->_authorization->isAllowed($aclResource);
    }
}
