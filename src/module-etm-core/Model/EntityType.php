<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model;

use Magento\Framework\Registry;
use Magento\Framework\Model\Context;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Validator\DataObject as EntityTypeValidator;
use Magento\Framework\Validator\UniversalFactory;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Eav\Model\Entity\StoreFactory;
use Magento\Eav\Model\Entity\AttributeFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Eav\Model\Entity\Type as EavEntityType;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Model\EntityType\ValidatorFactory;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType as ResourceEntityType;

/**
 * Entity type model class
 *
 * @category Ainnomix
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class EntityType extends EavEntityType implements EntityTypeInterface
{

    /**
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        AttributeFactory $attributeFactory,
        SetFactory $attSetFactory,
        StoreFactory $storeFactory,
        UniversalFactory $universalFactory,
        ValidatorFactory $validatorFactory,
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

        $this->validatorFactory = $validatorFactory;
    }

    /**
     * Configure model
     */
    protected function _construct(): void
    {
        $this->_init(ResourceEntityType::class);

        $this->_eventPrefix = 'etm_entity_type';
        $this->_eventObject = 'entity_type';
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeId(): ?int
    {
        $entityTypeId = parent::getEntityTypeId();
        return !is_null($entityTypeId) ? (int) $entityTypeId : null;
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeName(): ?string
    {
        return $this->getData(self::ENTITY_TYPE_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityTypeName(string $name): void
    {
        $this->setData(self::ENTITY_TYPE_NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityTypeCode(): ?string
    {
        return parent::getEntityTypeCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityTypeCode(string $code): void
    {
        $this->setData(self::ENTITY_TYPE_CODE, $code);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultAttributeSetId(): ?int
    {
        return (int) parent::getDefaultAttributeSetId();
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultAttributeSetId(int $attributeSetId): void
    {
        $this->setData(self::DEFAULT_ATTRIBUTE_SET_ID, $attributeSetId);
    }

    /**
     * Check is entity type custom
     *
     * @param bool|null $flag
     *
     * @return bool
     */
    public function isCustom(bool $flag = null): bool
    {
        $value = (bool) $this->getData('is_custom');
        if ($flag === null) {
            return $value;
        }

        $this->setData('is_custom', $flag);

        return $value;
    }

    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _getValidationRulesBeforeSave(): EntityTypeValidator
    {
        /** @var EntityTypeValidator $validator */
        $validator = $this->validatorFactory->create();

        return $validator;
    }
}
