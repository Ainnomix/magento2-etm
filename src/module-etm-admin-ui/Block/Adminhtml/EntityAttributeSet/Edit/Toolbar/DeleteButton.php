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

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttributeSet\Edit\Toolbar;

use Ainnomix\EtmAdminUi\Model\Ui\AttributeSetProvider;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button;

class DeleteButton extends Button
{

    /**
     * @var EntityTypeProvider
     */
    private $entityTypeProvider;

    /**
     * @var AttributeSetProvider
     */
    private $attributeSetProvider;

    /**
     * DeleteButton constructor
     *
     * @param Context              $context
     * @param EntityTypeProvider   $entityTypeProvider
     * @param AttributeSetProvider $attributeSetProvider
     * @param array                $data
     */
    public function __construct(
        Context $context,
        EntityTypeProvider $entityTypeProvider,
        AttributeSetProvider $attributeSetProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->entityTypeProvider = $entityTypeProvider;
        $this->attributeSetProvider = $attributeSetProvider;
    }

    /**
     * Configure button
     */
    protected function _construct(): void
    {
        $entityTypeId = (int) $this->getRequest()->getParam('entity_type_id');
        $attributeSetId = (int) $this->getRequest()->getParam('id');

        $deleteMessage = $this->escapeJs(
            __(
                'You are about to delete all entities in this attribute set. '
                . 'Are you sure you want to do that?'
            )
        );
        $deleteUrl = $this->getUrl(
            'etm/*/delete',
            ['id' => $attributeSetId, 'entity_type_id' => $entityTypeId]
        );
        $deleteAction = 'deleteConfirm(\'' . $deleteMessage . '\', \''
            . $deleteUrl . '\',{data: {}})';

        $this->setData('onclick', $deleteAction);

        parent::_construct();
    }

    /**
     * Check if current attribute set is default
     *
     * @return string
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _toHtml(): string
    {
        $entityType = $this->entityTypeProvider->get(
            (int) $this->getRequest()->getParam('entity_type_id')
        );
        $attributeSet = $this->attributeSetProvider->get(
            $entityType,
            (int) $this->getRequest()->getParam('id')
        );

        if ($entityType->getDefaultAttributeSetId() == $attributeSet->getAttributeSetId()) {
            return "";
        }

        return parent::_toHtml();
    }
}
