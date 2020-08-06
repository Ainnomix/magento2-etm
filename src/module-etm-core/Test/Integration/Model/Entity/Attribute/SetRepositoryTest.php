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

use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Ainnomix\EtmCore\Api\Data\AttributeSetSearchResultsInterface;
use Ainnomix\EtmCore\Test\Integration\Model\EntityTypeHelperTrait;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 * @magentoDataFixture attributeSetFixture
 */
class SetRepositoryTest extends TestCase
{

    use EntityTypeHelperTrait;

    /**
     * @var AttributeSetRepositoryInterface
     */
    protected $attributeSetRepository;

    protected function setUp()
    {
        $this->attributeSetRepository = Bootstrap::getObjectManager()->get(AttributeSetRepositoryInterface::class);
    }

    public function testGetList(): void
    {
        $entityType = $this->getEntityType();

        /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
        $searchCriteriaBuilder = Bootstrap::getObjectManager()->get(SearchCriteriaBuilder::class);
        $searchCriteriaBuilder->addFilter('entity_type_id', $entityType->getEntityTypeId(), 'eq');
        $searchCriteriaBuilder->addFilter('attribute_set_name', 'attribute_set_test', 'eq');
        $searchCriteria = $searchCriteriaBuilder->create();

        $searchResult = $this->attributeSetRepository->getList($searchCriteria);

        $this->assertInstanceOf(AttributeSetSearchResultsInterface::class, $searchResult);
        $this->assertCount(1, $searchResult->getItems());
        $this->assertEquals(1, $searchResult->getTotalCount());

        /** @var AttributeSetInterface $attributeSet */
        $attributeSet = current($searchResult->getItems());
        $this->assertEquals('attribute_set_test', $attributeSet->getAttributeSetName());
        $this->assertEquals($entityType->getEntityTypeId(), $attributeSet->getEntityTypeId());
    }

    public function testGet(): void
    {
        $entityType = $this->getEntityType();
        $originAttributeSet = $this->getAttributeSet($entityType);

        $attributeSet = $this->attributeSetRepository->get((int) $originAttributeSet->getAttributeSetId());
        $this->assertEquals('attribute_set_test', $attributeSet->getAttributeSetName());
        $this->assertEquals($originAttributeSet->getAttributeSetName(), $attributeSet->getAttributeSetName());
        $this->assertEquals($entityType->getEntityTypeId(), $attributeSet->getEntityTypeId());
    }

    public function testDeleteById(): void
    {
        $entityType = $this->getEntityType();
        $originAttributeSet = $this->getAttributeSet($entityType);

        $this->attributeSetRepository->deleteById((int) $originAttributeSet->getAttributeSetId());

        $this->expectException(NoSuchEntityException::class);

        $this->attributeSetRepository->get((int) $originAttributeSet->getAttributeSetId());
    }

    public function testSave(): void
    {
        $entityType = $this->getEntityType();

        $attributeSetFactory = Bootstrap::getObjectManager()->get(AttributeSetInterfaceFactory::class);

        /** @var AttributeSetInterface $attributeSet */
        $attributeSet = $attributeSetFactory->create();
        $attributeSet->setAttributeSetName('Attribute Set Save Test');
        $attributeSet->setEntityTypeId($entityType->getEntityTypeId());
        $attributeSet->setSortOrder(110);

        $attributeSetId = $this->attributeSetRepository->save($attributeSet);
        $this->assertNotEmpty($attributeSetId);

        $attributeSet = $this->attributeSetRepository->get((int) $attributeSetId);

        $this->assertEquals('Attribute Set Save Test', $attributeSet->getAttributeSetName());
        $this->assertEquals($attributeSetId, $attributeSet->getAttributeSetId());
        $this->assertEquals($entityType->getEntityTypeId(), $attributeSet->getEntityTypeId());
    }

    public static function attributeSetFixture(): void
    {
        $entityType = self::getEntityType();
        self::getAttributeSet($entityType);
    }
}
