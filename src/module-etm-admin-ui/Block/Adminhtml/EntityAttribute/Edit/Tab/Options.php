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

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttribute\Edit\Tab;

use Ainnomix\EtmAdminUi\Ui\Resolver\Attribute as AttributeResolver;
use Magento\Eav\Block\Adminhtml\Attribute\Edit\Options\Options as EavOptions;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Validator\UniversalFactory;

class Options extends EavOptions
{

    /**
     * @var AttributeResolver
     */
    protected $attributeResolver;

    public function __construct(
        Context $context,
        Registry $registry,
        CollectionFactory $attrOptionCollectionFactory,
        UniversalFactory $universalFactory,
        AttributeResolver $attributeResolver,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $attrOptionCollectionFactory,
            $universalFactory,
            $data
        );

        $this->attributeResolver = $attributeResolver;
    }

    protected function getAttributeObject()
    {
        return $this->attributeResolver->get();
    }
}
