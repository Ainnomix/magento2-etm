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

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttribute\Edit\Tab;

use Ainnomix\EtmAdminUi\Ui\Resolver\Attribute as AttributeResolver;
use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Store\Model\ResourceModel\Store\Collection;

class Labels extends Template
{
    /**
     * @var AttributeResolver
     */
    protected $attributeResolver;

    /**
     * @var string
     *
     * @SuppressWarnings(PHPMD.CamelCasePropertyName)
     */
    protected $_template = 'Ainnomix_EtmAdminUi::attribute/edit/labels.phtml';

    public function __construct(
        Context $context,
        AttributeResolver $attributeResolver,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->attributeResolver = $attributeResolver;
    }

    /**
     * Retrieve stores collection with default store
     *
     * @return Collection
     */
    public function getStores()
    {
        if (!$this->hasStores()) {
            $this->setData('stores', $this->_storeManager->getStores());
        }
        return $this->_getData('stores');
    }

    /**
     * Retrieve frontend labels of attribute for each store
     *
     * @return array
     */
    public function getLabelValues()
    {
        $values = (array) $this->getAttributeObject()->getFrontend()->getLabel();
        $storeLabels = $this->getAttributeObject()->getStoreLabels();
        foreach ($this->getStores() as $store) {
            if ($store->getId() != 0) {
                $values[$store->getId()] = isset($storeLabels[$store->getId()]) ? $storeLabels[$store->getId()] : '';
            }
        }

        return $values;
    }

    /**
     * Retrieve attribute object from registry
     *
     * @return AttributeInterface
     */
    protected function getAttributeObject()
    {
        return $this->attributeResolver->get();
    }
}
