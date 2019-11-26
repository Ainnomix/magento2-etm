<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model;

use Magento\Framework\Registry;
use Magento\Framework\Model\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Validator\UniversalFactory;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Eav\Model\Entity\StoreFactory;
use Magento\Eav\Model\Entity\AttributeFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Eav\Model\Entity\Type as EavEntityType;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as ResourceEntityType;

/**
 * Entity type model class
 *
 * @category Ainnomix
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class EntityType extends EavEntityType
{

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var EntityTypeInterfaceFactory
     */
    protected $entityTypeFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        AttributeFactory $attributeFactory,
        SetFactory $attSetFactory,
        StoreFactory $storeFactory,
        UniversalFactory $universalFactory,
        DataObjectHelper $dataObjectHelper,
        EntityTypeInterfaceFactory $entityTypeFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $attributeFactory,
            $attSetFactory,
            $storeFactory,
            $universalFactory,
            $resource,
            $resourceCollection,
            $data
        );

        $this->dataObjectHelper = $dataObjectHelper;
        $this->entityTypeFactory = $entityTypeFactory;
    }

    /**
     * Configure model
     */
    protected function _construct(): void
    {
        $this->_init(ResourceEntityType::class);
    }

    /**
     * Create and populate entity data model
     *
     * @return EntityTypeInterface
     */
    public function getDataModel(): EntityTypeInterface
    {
        $entityTypeData = $this->getData();
        $entityDataObject = $this->entityTypeFactory->create();

        $this->dataObjectHelper->populateWithArray(
            $entityDataObject,
            $entityTypeData,
            EntityTypeInterface::class
        );

        return $entityDataObject;
    }
}
