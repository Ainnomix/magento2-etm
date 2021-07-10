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

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttributeSet\Edit\Main;

use Ainnomix\EtmAdminUi\Model\Ui\AttributeSetProvider;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Formset extends Generic
{

    /**
     * @var EntityTypeProvider
     */
    private $entityTypeProvider;

    /**
     * @var AttributeSetProvider
     */
    private $attributeSetProvider;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        EntityTypeProvider $entityTypeProvider,
        AttributeSetProvider $attributeSetProvider,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $data
        );

        $this->entityTypeProvider = $entityTypeProvider;
        $this->attributeSetProvider = $attributeSetProvider;
    }

    /**
     * @return Formset
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _prepareForm()
    {
        $entityTypeId = (int) $this->getRequest()->getParam('entity_type_id');
        $attributeSet = $this->getAttributeSet();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset('set_name', ['legend' => __('Edit Attribute Set Name')]);
        $fieldset->addField(
            'attribute_set_name',
            'text',
            [
                'label' => __('Name'),
                'note' => __('For internal use'),
                'name' => 'attribute_set_name',
                'required' => true,
                'class' => 'required-entry validate-no-html-tags',
                'value' => $attributeSet->getAttributeSetName()
            ]
        );

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('set-prop-form');
        $form->setAction(
            $this->getUrl('etm/*/save', ['entity_type_id' => $entityTypeId])
        );
        $form->setOnsubmit('return false;');
        $this->setForm($form);

        return $this;
    }

    protected function getAttributeSet(): AttributeSetInterface
    {
        $entityTypeId = (int) $this->getRequest()->getParam('entity_type_id');
        $attributeSetId = (int) $this->getRequest()->getParam('id');

        return $this->attributeSetProvider->get(
            $this->entityTypeProvider->get($entityTypeId),
            $attributeSetId
        );
    }
}
