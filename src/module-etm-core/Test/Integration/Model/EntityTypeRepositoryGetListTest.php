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

namespace Ainnomix\EtmCore\Test\Integration\Model;

use Ainnomix\EtmCore\Model\Data\EntityTypeSearchResults;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\TestFramework\Helper\Bootstrap;

/**
 * Test class for "getList" action of EntityTypeRepository
 *
 * @magentoDbIsolation enabled
 */
class EntityTypeRepositoryGetListTest extends EntityTypeRepositoryTest
{

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    protected function setUp()
    {
        parent::setUp();

        $this->searchCriteriaBuilder = Bootstrap::getObjectManager()->create(SearchCriteriaBuilder::class);
        $this->filterBuilder = Bootstrap::getObjectManager()->create(FilterBuilder::class);
    }

    /**
     * @param array $typeList
     * @param int   $collectionSize
     *
     * @dataProvider providerEntityTypeGetList
     */
    public function testEntityTypeGetList(array $typeList, int $collectionSize): void
    {
        $typeCodes = [];
        foreach ($typeList as $entityTypeData) {
            $entityTypeCode = $entityTypeData[0];
            $typeCodes[]    = $entityTypeCode;

            if (true === $entityTypeData[1]) {
                $this->createEntityType($entityTypeCode, $entityTypeCode);
            }
        }

        $codeFilter = $this->filterBuilder
            ->setField('entity_type_code')
            ->setValue($typeCodes)
            ->setConditionType('in')
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder->addFilters([$codeFilter])->create();

        $searchResult = $this->entityTypeRepository->getList($searchCriteria);

        $this->assertInstanceOf(EntityTypeSearchResults::class, $searchResult);
        $this->assertEquals($collectionSize, $searchResult->getTotalCount());
    }

    public function providerEntityTypeGetList(): array
    {
        return [
            'Custom entity types' => [
                [['entity_type_400', true], ['entity_type_410', true]], 2
            ],
            'Mixed entity types'  => [
                [['entity_type_410', true], ['catalog_product', false]], 1
            ]
        ];
    }
}
