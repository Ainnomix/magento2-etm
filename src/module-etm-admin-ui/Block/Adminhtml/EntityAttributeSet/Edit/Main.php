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

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttributeSet\Edit;

use Magento\Backend\Block\Template;
use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonEncoder;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory as GroupCollectionFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory as AttributeCollectionFactory;

class Main extends Template
{

    /**
     * @var GroupCollectionFactory
     */
    private $groupCollectionFactory;

    /**
     * @var AttributeCollectionFactory
     */
    private $attributeCollectionFactory;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $jsonEncoder;

    /**
     * Main constructor
     *
     * @param Template\Context           $context
     * @param GroupCollectionFactory     $groupCollectionFactory
     * @param AttributeCollectionFactory $attributeCollectionFactory
     * @param JsonEncoder                $jsonEncoder
     * @param array                      $data
     */
    public function __construct(
        Template\Context $context,
        GroupCollectionFactory $groupCollectionFactory,
        AttributeCollectionFactory $attributeCollectionFactory,
        JsonEncoder $jsonEncoder,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->attributeCollectionFactory = $attributeCollectionFactory;
        $this->jsonEncoder = $jsonEncoder;
    }

    /**
     * Retrieve Attribute Set Edit Form HTML
     *
     * @return string
     */
    public function getSetFormHtml(): string
    {
        return $this->getChildHtml('edit_set_form');
    }

    /**
     * Retrieve Add New Group Button HTML
     *
     * @return string
     */
    public function getAddGroupButton(): string
    {
        return $this->getChildHtml('add_group_button');
    }

    /**
     * Retrieve Delete Group Button HTML
     *
     * @return string
     */
    public function getDeleteGroupButton(): string
    {
        return $this->getChildHtml('delete_group_button');
    }

    /**
     * Retrieve Attribute Set Save URL
     *
     * @return string
     */
    public function getMoveUrl(): string
    {
        $params = [
            'entity_type_id' => (int) $this->getRequest()->getParam('entity_type_id')
        ];

        if ((int) $this->getRequest()->getParam('id')) {
            $params['id'] = (int) $this->getRequest()->getParam('id');
        }

        return $this->getUrl('etm/entityAttributeSet/save', $params);
    }

    /**
     * Retrieve Attribute Set Group Tree as JSON format
     *
     * @return string
     */
    public function getGroupTreeJson(): string
    {
        $items = [];
        $attributeSetId = (int) $this->getRequest()->getParam('id');

        $groupsCollection = $this->groupCollectionFactory->create();
        $groupsCollection->setAttributeSetFilter($attributeSetId)
            ->setSortOrder();

        foreach ($groupsCollection as $node) {
            $item = [];
            $item['text'] = $this->escapeHtml($node->getAttributeGroupName());
            $item['id'] = $node->getAttributeGroupId();
            $item['cls'] = 'folder';
            $item['allowDrop'] = true;
            $item['allowDrag'] = true;

            $nodeChildren = $this->attributeCollectionFactory->create();
            $nodeChildren->setAttributeGroupFilter($node->getId());

            if ($nodeChildren->getSize() > 0) {
                $item['children'] = [];
                foreach ($nodeChildren->getItems() as $child) {
                    $item['children'][] = $this->mapAttribute($child);
                }
            }

            $items[] = $item;
        }

        return $this->jsonEncoder->serialize($items);
    }

    /**
     * Retrieve Unused in Attribute Set Attribute Tree as JSON
     *
     * @return string
     */
    public function getAttributeTreeJson(): string
    {
        $items = [];
        $attributeSetId = (int) $this->getRequest()->getParam('id');
        $entityTypeId = (int) $this->getRequest()->getParam('entity_type_id');

        $collection = $this->attributeCollectionFactory->create()
            ->setAttributeSetFilter($attributeSetId);

        $attributesIds = ['0'];
        /* @var $item AttributeInterface */
        foreach ($collection->getItems() as $item) {
            $attributesIds[] = $item->getAttributeId();
        }

        $attributes = $this->attributeCollectionFactory->create()
            ->setEntityTypeFilter($entityTypeId)
            ->setAttributesExcludeFilter($attributesIds);

        foreach ($attributes as $child) {
            $attr = [
                'text' => $this->escapeHtml($child->getAttributeCode()),
                'id' => $child->getAttributeId(),
                'cls' => 'leaf',
                'allowDrop' => false,
                'allowDrag' => true,
                'leaf' => true,
                'is_user_defined' => $child->getIsUserDefined(),
                'entity_id' => $child->getEntityId(),
            ];

            $items[] = $attr;
        }

        if (count($items) == 0) {
            $items[] = [
                'text' => __('Empty'),
                'id' => 'empty',
                'cls' => 'folder',
                'allowDrop' => false,
                'allowDrag' => false,
            ];
        }

        return $this->jsonEncoder->serialize($items);
    }

    /**
     * Map attribute data
     *
     * @param AttributeInterface $attribute
     *
     * @return array
     */
    protected function mapAttribute(AttributeInterface $attribute): array
    {
        return [
            'text' => $attribute->getAttributeCode(),
            'id' => $attribute->getAttributeId(),
            'cls' => 'leaf',
            'allowDrop' => false,
            'allowDrag' => true,
            'leaf' => true,
            'is_user_defined' => $attribute->getIsUserDefined(),
            'is_unassignable' => false,
            'entity_id' => $attribute->getEntityAttributeId()
        ];
    }
}
