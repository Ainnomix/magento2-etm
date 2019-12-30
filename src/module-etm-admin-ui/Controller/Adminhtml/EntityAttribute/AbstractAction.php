<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttribute;

use Magento\Backend\App\Action;
use Ainnomix\EtmAdminUi\Model\Acl\Resource\NameProvider;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Exception\NoSuchEntityException;

abstract class AbstractAction extends Action
{

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    /**
     * @var NameProvider
     */
    protected $nameProvider;

    /**
     * @var EntityTypeInterface
     */
    private $entityType;

    public function __construct(
        Action\Context $context,
        EntityTypeRepositoryInterface $entityTypeRepository,
        NameProvider $nameProvider
    ) {
        parent::__construct($context);

        $this->entityTypeRepository = $entityTypeRepository;
        $this->nameProvider = $nameProvider;
    }

    /**
     * @return EntityTypeInterface
     *
     * @throws NotFoundException
     */
    protected function getEntityType(): EntityTypeInterface
    {
        if (!$this->entityType) {
            try {
                $entityTypeId = (int) $this->getRequest()->getParam('entity_type_id');
                $this->entityType = $this->entityTypeRepository->getById($entityTypeId);
            } catch (NoSuchEntityException $exception) {
                throw new NotFoundException(__($exception->getMessage()), $exception);
            }
        }

        return $this->entityType;
    }

    /**
     * @return bool
     *
     * @throws NotFoundException
     */
    protected function _isAllowed()
    {
        $aclResource = $this->nameProvider->getAttributesNodeId($this->getEntityType());

        return $this->_authorization->isAllowed($aclResource);
    }
}
