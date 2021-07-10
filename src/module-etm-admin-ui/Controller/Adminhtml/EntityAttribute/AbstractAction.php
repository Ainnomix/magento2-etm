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

use Ainnomix\EtmCore\Api\AttributeRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Ainnomix\EtmCore\Api\Data\AttributeInterfaceFactory;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttribute\Context as AttributeContext;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType;
use Ainnomix\EtmAdminUi\Ui\Resolver\Attribute as AttributeResolver;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;

abstract class AbstractAction extends EntityType
{

    /**
     * @var AttributeResolver
     */
    protected $attributeResolver;

    /**
     * @var AttributeInterfaceFactory
     */
    protected $attributeFactory;

    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * AbstractAction constructor
     *
     * @param Context          $context
     * @param AttributeContext $attributeContext
     */
    public function __construct(
        Context $context,
        AttributeContext $attributeContext
    ) {
        parent::__construct($context, $attributeContext);

        $this->attributeResolver = $attributeContext->getAttributeResolver();
        $this->attributeFactory = $attributeContext->getAttributeFactory();
        $this->attributeRepository = $attributeContext->getAttributeRepository();
    }

    /**
     * Retrieve current attribute instance
     * If attribute ID parameter is missing a new empty attribute instance will be created
     *
     * @return AttributeInterface
     *
     * @throws NoSuchEntityException
     */
    protected function getAttribute(): AttributeInterface
    {
        $attributeId = $this->getRequest()->getParam('id', false);
        if (false === $attributeId) {
            $attribute = $this->attributeFactory->create();
            $attribute->setEntityTypeId($this->getEntityType()->getEntityTypeId());

            $this->attributeResolver->set($attribute);
        }

        if (false !== $attributeId) {
            $attribute = $this->attributeResolver->get();
        }

        return $attribute;
    }
}
