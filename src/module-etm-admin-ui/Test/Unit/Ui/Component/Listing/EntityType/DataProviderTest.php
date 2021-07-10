<?php
/*
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

namespace Ainnomix\EtmAdminUi\Test\Unit\Ui\Component\Listing\EntityType;

use Ainnomix\EtmAdminUi\Ui\Component\Listing\EntityType\DataProvider;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DataProviderTest extends TestCase
{

    /**
     * @var MockObject|SearchCriteriaBuilder
     */
    private $criteriaBuilderMock;

    /**
     * @var MockObject|FilterBuilder
     */
    private $filterBuilderMock;

    /**
     * @var MockObject|SearchCriteria
     */
    private $searchCriteriaMock;

    /**
     * @var DataProvider
     */
    private $dataProvider;

    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);
        $this->filterBuilderMock = $this->getMockBuilder(FilterBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'setField',
                    'setValue',
                    'setConditionType',
                    'create'
                ]
            )->getMock();
        $this->criteriaBuilderMock = $this->getMockBuilder(SearchCriteriaBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'create',
                    'addFilter'
                ]
            )->getMock();
        $this->searchCriteriaMock = $this->getMockBuilder(SearchCriteria::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'setRequestName'
                ]
            )->getMock();

        $this->dataProvider = $objectManager->getObject(
            DataProvider::class,
            [
                'name'                  => 'etm_entity_type_listing_data_source',
                'filterBuilder'         => $this->filterBuilderMock,
                'searchCriteriaBuilder' => $this->criteriaBuilderMock
            ]
        );
    }

    public function testGetSearchCriteria(): void
    {
        $filterMock = $this->createMock(Filter::class);
        $this->filterBuilderMock->expects($this->any())
            ->method('setField')
            ->with('is_custom')
            ->willReturn($this->filterBuilderMock);
        $this->filterBuilderMock->expects($this->any())
            ->method('setValue')
            ->with(1)
            ->willReturn($this->filterBuilderMock);
        $this->filterBuilderMock->expects($this->any())
            ->method('setConditionType')
            ->with('eq')
            ->willReturn($this->filterBuilderMock);
        $this->filterBuilderMock->expects($this->any())
            ->method('create')
            ->willReturn($filterMock);

        $this->criteriaBuilderMock->expects($this->any())
            ->method('addFilter')
            ->with($filterMock);
        $this->criteriaBuilderMock->expects($this->once())
            ->method('create')
            ->willReturn($this->searchCriteriaMock);
        $this->searchCriteriaMock->expects($this->once())
            ->method('setRequestName')
            ->with('etm_entity_type_listing_data_source');

        $searchCriteria = $this->dataProvider->getSearchCriteria();
        $this->assertInstanceOf(SearchCriteria::class, $searchCriteria);
    }
}
