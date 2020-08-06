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

namespace Ainnomix\EtmCore\Test\Integration\Model\Entity\Attribute;

use Ainnomix\EtmCore\Api\AttributeGroupRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterfaceFactory;
use Ainnomix\EtmCore\Test\Integration\Model\EntityTypeHelperTrait;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 * @magentoDataFixture attributeGroupFixture
 */
class GroupRepositoryTest extends TestCase
{

    use EntityTypeHelperTrait;

    /**
     * @var AttributeGroupRepositoryInterface
     */
    protected $attributeGroupRepository;

    protected function setUp()
    {
        $this->attributeGroupRepository = Bootstrap::getObjectManager()->get(AttributeGroupRepositoryInterface::class);
    }

    public function testGetList(): void
    {
        $entityType = $this->getEntityType();
        $attributeSet = $this->getAttributeSet($entityType);

        /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
        $searchCriteriaBuilder = Bootstrap::getObjectManager()->get(SearchCriteriaBuilder::class);
        $searchCriteriaBuilder->addFilter('attribute_set_id', $attributeSet->getAttributeSetId(), 'eq');
        $searchCriteriaBuilder->addFilter('attribute_group_name', 'attribute_group_test', 'eq');
        $searchCriteria = $searchCriteriaBuilder->create();

        $searchResult = $this->attributeGroupRepository->getList($searchCriteria);

        $this->assertEquals(1, $searchResult->getTotalCount());
        $this->assertCount(1, $searchResult->getItems());

        /** @var AttributeGroupInterface $attributeGroup */
        $attributeGroup = current($searchResult->getItems());

        $this->assertEquals('attribute_group_test', $attributeGroup->getAttributeGroupName());
        $this->assertEquals($attributeSet->getAttributeSetId(), $attributeGroup->getAttributeSetId());
    }

    public function testGet(): void
    {
        $entityType = $this->getEntityType();
        $attributeSet = $this->getAttributeSet($entityType);
        $originAttributeGroup = $this->getAttributeGroup($attributeSet);

        $attributeGroup = $this->attributeGroupRepository->get((int) $originAttributeGroup->getAttributeGroupId());

        $this->assertEquals($originAttributeGroup->getAttributeGroupId(), $attributeGroup->getAttributeGroupId());
        $this->assertEquals('attribute_group_test', $attributeGroup->getAttributeGroupName());
        $this->assertEquals($attributeSet->getAttributeSetId(), $attributeGroup->getAttributeSetId());
    }

    public function testDeleteById(): void
    {
        $entityType = $this->getEntityType();
        $attributeSet = $this->getAttributeSet($entityType);
        $originAttributeGroup = $this->getAttributeGroup($attributeSet);

        $this->attributeGroupRepository->deleteById((int) $originAttributeGroup->getAttributeGroupId());

        $this->expectException(NoSuchEntityException::class);
        $this->attributeGroupRepository->get((int) $originAttributeGroup->getAttributeGroupId());
    }

    public function testSave(): void
    {
        $entityType = $this->getEntityType();
        $attributeSet = $this->getAttributeSet($entityType);

        /** @var AttributeGroupInterfaceFactory $attributeGroupFactory */
        $attributeGroupFactory = Bootstrap::getObjectManager()->get(AttributeGroupInterfaceFactory::class);

        $attributeGroup = $attributeGroupFactory->create();
        $attributeGroup->setAttributeSetId((int) $attributeSet->getAttributeSetId());
        $attributeGroup->setAttributeGroupName('attribute_group_test1');

        $attributeGroupId = $this->attributeGroupRepository->save($attributeGroup);

        $this->assertNotEmpty($attributeGroupId);

        $attributeGroup = $this->attributeGroupRepository->get($attributeGroupId);
        $this->assertEquals($attributeGroupId, $attributeGroup->getAttributeGroupId());
        $this->assertEquals('attribute_group_test1', $attributeGroup->getAttributeGroupName());
        $this->assertEquals($attributeSet->getAttributeSetId(), $attributeGroup->getAttributeSetId());
    }

    public static function attributeGroupFixture(): void
    {
        $entityType = self::getEntityType();
        $attributeSet = self::getAttributeSet($entityType);
        self::getAttributeGroup($attributeSet);
    }
}
