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

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Eav\Model\Adminhtml\System\Config\Source\InputtypeFactory;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttribute\PropertyLocker;
use Ainnomix\EtmAdminUi\Ui\Resolver\Attribute as AttributeResolver;

class Main extends Generic
{

    /**
     * @var Yesno
     */
    protected $booleanSource;

    /**
     * @var PropertyLocker
     */
    protected $propertyLocker;

    /**
     * @var InputtypeFactory
     */
    protected $inputTypeFactory;

    /**
     * @var AttributeResolver
     */
    protected $attributeResolver;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Yesno $booleanSource,
        PropertyLocker $propertyLocker,
        InputtypeFactory $inputTypeFactory,
        AttributeResolver $attributeResolver,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $data
        );

        $this->booleanSource = $booleanSource;
        $this->propertyLocker = $propertyLocker;
        $this->inputTypeFactory = $inputTypeFactory;
        $this->attributeResolver = $attributeResolver;
    }

    /**
     * @return Main
     *
     * @throws LocalizedException
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _prepareForm()
    {
        $attributeObject = $this->getAttributeObject();
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Attribute Properties')]);

        if ($attributeObject->getAttributeId()) {
            $fieldset->addField('attribute_id', 'hidden', ['name' => 'attribute_id']);
        }

        $labels = $attributeObject->getFrontendLabel();
        $fieldset->addField(
            'attribute_label',
            'text',
            [
                'name' => 'frontend_label[0]',
                'label' => __('Default Label'),
                'title' => __('Default label'),
                'required' => true,
                'value' => is_array($labels) ? $labels[0] : $labels
            ]
        );

        $fieldset->addField(
            'frontend_input',
            'select',
            [
                'name' => 'frontend_input',
                'label' => __('Catalog Input Type for Store Owner'),
                'title' => __('Catalog Input Type for Store Owner'),
                'value' => 'text',
                'values' => $this->inputTypeFactory->create()->toOptionArray()
            ]
        );

        $fieldset->addField(
            'is_required',
            'select',
            [
                'name' => 'is_required',
                'label' => __('Values Required'),
                'title' => __('Values Required'),
                'values' => $this->booleanSource->toOptionArray()
            ]
        );

        $this->propertyLocker->lock($form);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return Main
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initFormValues()
    {
        $this->getForm()->addValues($this->getAttributeObject()->getData());

        return parent::_initFormValues();
    }

    /**
     * @param string $html
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _afterToHtml($html)
    {
        $jsScripts = $this->getLayout()->createBlock(\Magento\Eav\Block\Adminhtml\Attribute\Edit\Js::class)
            ->toHtml();
        return $html . $jsScripts;
    }

    protected function getAttributeObject()
    {
        return $this->attributeResolver->get();
    }
}
