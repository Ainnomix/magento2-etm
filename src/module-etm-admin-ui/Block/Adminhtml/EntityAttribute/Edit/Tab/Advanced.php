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

use IntlDateFormatter;
use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Eav\Helper\Data as EavHelper;
use Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttribute\PropertyLocker;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Ainnomix\EtmAdminUi\Ui\Resolver\Attribute as AttributeResolver;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Advanced extends Generic
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
     * @var EavHelper
     */
    protected $eavHelper;

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
        EavHelper $eavHelper,
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
        $this->eavHelper = $eavHelper;
        $this->attributeResolver = $attributeResolver;
    }

    protected function _prepareForm()
    {
        $attributeObject = $this->getAttributeObject();

        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $fieldset = $form->addFieldset(
            'advanced_fieldset',
            ['legend' => __('Advanced Attribute Properties'), 'collapsable' => true]
        );

        $validateClass = sprintf(
            'validate-code validate-length maximum-length-%d',
            \Magento\Eav\Model\Entity\Attribute::ATTRIBUTE_CODE_MAX_LENGTH
        );
        $fieldset->addField(
            'attribute_code',
            'text',
            [
                'name' => 'attribute_code',
                'label' => __('Attribute Code'),
                'title' => __('Attribute Code'),
                'note' => __(
                    'This is used internally. Make sure you don\'t use spaces or more than %1 symbols.',
                    \Magento\Eav\Model\Entity\Attribute::ATTRIBUTE_CODE_MAX_LENGTH
                ),
                'class' => $validateClass
            ]
        );

        $fieldset->addField(
            'default_value_text',
            'text',
            [
                'name' => 'default_value_text',
                'label' => __('Default Value'),
                'title' => __('Default Value'),
                'value' => $attributeObject->getDefaultValue()
            ]
        );

        $fieldset->addField(
            'default_value_yesno',
            'select',
            [
                'name' => 'default_value_yesno',
                'label' => __('Default Value'),
                'title' => __('Default Value'),
                'values' => $this->booleanSource->toOptionArray(),
                'value' => $attributeObject->getDefaultValue()
            ]
        );

        $dateFormat = $this->_localeDate->getDateFormat(IntlDateFormatter::SHORT);
        $fieldset->addField(
            'default_value_date',
            'date',
            [
                'name' => 'default_value_date',
                'label' => __('Default Value'),
                'title' => __('Default Value'),
                'value' => $attributeObject->getDefaultValue(),
                'date_format' => $dateFormat
            ]
        );

        $fieldset->addField(
            'default_value_textarea',
            'textarea',
            [
                'name' => 'default_value_textarea',
                'label' => __('Default Value'),
                'title' => __('Default Value'),
                'value' => $attributeObject->getDefaultValue()
            ]
        );

        $fieldset->addField(
            'is_unique',
            'select',
            [
                'name' => 'is_unique',
                'label' => __('Unique Value'),
                'title' => __('Unique Value (not shared with other products)'),
                'note' => __('Not shared with other products.'),
                'values' => $this->booleanSource->toOptionArray()
            ]
        );

        $fieldset->addField(
            'frontend_class',
            'select',
            [
                'name' => 'frontend_class',
                'label' => __('Input Validation for Store Owner'),
                'title' => __('Input Validation for Store Owner'),
                'values' => $this->eavHelper->getFrontendClasses(
                    $attributeObject->getEntityType()->getEntityTypeCode()
                )
            ]
        );

        $fieldset->addField(
            'is_used_in_grid',
            'select',
            [
                'name' => 'is_used_in_grid',
                'label' => __('Add to Column Options'),
                'title' => __('Add to Column Options'),
                'values' => $this->booleanSource->toOptionArray(),
                'value' => $attributeObject->getData('is_used_in_grid') ?: 1,
                'note' => __('Select "Yes" to add this attribute to the list of column options in the product grid.'),
            ]
        );

        $fieldset->addField(
            'is_visible_in_grid',
            'hidden',
            [
                'name' => 'is_visible_in_grid',
                'value' => $attributeObject->getData('is_visible_in_grid') ?: 1,
            ]
        );

        $fieldset->addField(
            'is_filterable_in_grid',
            'select',
            [
                'name' => 'is_filterable_in_grid',
                'label' => __('Use in Filter Options'),
                'title' => __('Use in Filter Options'),
                'values' => $this->booleanSource->toOptionArray(),
                'value' => $attributeObject->getData('is_filterable_in_grid') ?: 1,
                'note' => __('Select "Yes" to add this attribute to the list of filter options in the product grid.'),
            ]
        );

        if ($attributeObject->getId()) {
            $form->getElement('attribute_code')->setDisabled(1);
            if (!$attributeObject->getIsUserDefined()) {
                $form->getElement('is_unique')->setDisabled(1);
            }
        }

        $scopes = [
            ScopedAttributeInterface::SCOPE_STORE => __('Store View'),
            ScopedAttributeInterface::SCOPE_WEBSITE => __('Website'),
            ScopedAttributeInterface::SCOPE_GLOBAL => __('Global'),
        ];
        $fieldset->addField(
            'is_global',
            'select',
            [
                'name' => 'is_global',
                'label' => __('Scope'),
                'title' => __('Scope'),
                'note' => __('Declare attribute value saving scope.'),
                'values' => $scopes
            ],
            'attribute_code'
        );

        $this->setForm($form);
        $this->propertyLocker->lock($form);
        return $this;
    }

    /**
     * Initialize form fields values
     *
     * @return Advanced
     */
    protected function _initFormValues()
    {
        $this->getForm()->addValues($this->getAttributeObject()->getData());

        return parent::_initFormValues();
    }

    /**
     * Retrieve attribute object from registry
     *
     * @return AttributeInterface
     */
    private function getAttributeObject()
    {
        return $this->attributeResolver->get();
    }
}
