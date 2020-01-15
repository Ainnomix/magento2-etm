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

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context as TypeContext;
use Ainnomix\EtmAdminUi\Model\Ui\AttributeSetProvider;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;

abstract class AbstractAction extends EntityType
{

    /**
     * @var AttributeSetProvider
     */
    protected $attributeSetProvider;

    /**
     * AbstractAction constructor
     *
     * @param Context              $context
     * @param TypeContext          $typeContext
     * @param AttributeSetProvider $attributeSetProvider
     */
    public function __construct(
        Context $context,
        TypeContext $typeContext,
        AttributeSetProvider $attributeSetProvider
    ) {
        parent::__construct($context, $typeContext);

        $this->attributeSetProvider = $attributeSetProvider;
    }

    /**
     * Retrieve current attribute set instance
     *
     * @return AttributeSetInterface
     *
     * @throws NoSuchEntityException
     */
    protected function getAttributeSet(): AttributeSetInterface
    {
        $attributeSetId = (int) $this->getRequest()->getParam('id');

        return $this->attributeSetProvider->get($this->getEntityType(), $attributeSetId);
    }
}
