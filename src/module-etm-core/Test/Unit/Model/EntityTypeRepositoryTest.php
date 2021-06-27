<?php

declare(strict_types=1);

namespace Ainnomix\EtmCore\Test\Unit\Model;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeSearchResultsInterface;
use Ainnomix\EtmCore\Model\Data\EntityTypeSearchResults;
use Ainnomix\EtmCore\Model\EntityType;
use Ainnomix\EtmCore\Model\EntityType\Command;
use Ainnomix\EtmCore\Model\EntityTypeRepository;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;

class EntityTypeRepositoryTest extends \PHPUnit\Framework\TestCase
{

    protected $objectManagerHelper;

    /**
     * @var EntityType
     */
    protected $entityType;

    protected $commandGetMock;

    protected $commandGetByIdMock;

    protected $commandGetListMock;

    protected $commandSaveMock;

    protected $commandDeleteByIdMock;

    /**
     * @var EntityTypeRepository
     */
    protected $repository;

    protected function setUp(): void
    {
        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->entityType = $this->objectManagerHelper->getObject(EntityType::class);

        $this->commandGetMock = $this->getMockBuilder(Command\GetInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['execute'])
            ->getMock();
        $this->commandGetByIdMock = $this->getMockBuilder(Command\GetByIdInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['execute'])
            ->getMock();
        $this->commandGetListMock = $this->createPartialMock(Command\GetListInterface::class, []);
        $this->commandSaveMock = $this->getMockBuilder(Command\SaveInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['execute'])
            ->getMock();
        $this->commandDeleteByIdMock = $this->getMockBuilder(Command\DeleteByIdInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['execute'])
            ->getMock();

        $this->repository = $this->objectManagerHelper->getObject(
            EntityTypeRepository::class,
            [
                'commandGet' => $this->commandGetMock,
                'commandGetById' => $this->commandGetByIdMock,
                'commandGetList' => $this->commandGetListMock,
                'commandSave' => $this->commandSaveMock,
                'commandDeleteById' => $this->commandDeleteByIdMock
            ]
        );
    }

    public function testGet(): void
    {
        $entityTypeCode = 'test_custom_entity';
        $this->entityType->setEntityTypeCode($entityTypeCode);

        $this->commandGetMock->expects($this->once())->method('execute')->with($entityTypeCode)->willReturn($this->entityType);
        $result = $this->repository->get($entityTypeCode);

        $this->assertInstanceOf(EntityTypeInterface::class, $result);
        $this->assertEquals($result->getEntityTypeCode(), $entityTypeCode);
    }

    public function testGetById(): void
    {
        $entityTypeId = 100;
        $this->entityType->setData('entity_type_id', $entityTypeId);

        $this->commandGetByIdMock->expects($this->once())->method('execute')->with($entityTypeId)->willReturn($this->entityType);
        $result = $this->repository->getById($entityTypeId);

        $this->assertInstanceOf(EntityTypeInterface::class, $result);
        $this->assertEquals($result->getEntityTypeId(), $entityTypeId);
    }

    public function testSave(): void
    {
        $entityTypeId = 100;

        $this->entityType->setData('entity_type_id', $entityTypeId);
        $this->commandSaveMock->expects($this->once())->method('execute')->with($this->entityType)->willReturn($entityTypeId);
        $result = $this->repository->save($this->entityType);

        $this->assertEquals($result, $entityTypeId);
    }

    public function testDeleteById(): void
    {
        $entityTypeId = 100;

        $this->commandDeleteByIdMock->expects($this->once())->method('execute')->with($entityTypeId);
        $this->repository->deleteById($entityTypeId);
    }

    public function testGetList(): void
    {
        $searchCriteria = $this->objectManagerHelper->getObject(\Magento\Framework\Api\SearchCriteria::class);
        /** @var EntityTypeSearchResults $searchResult */
        $searchResult = $this->objectManagerHelper->getObject(EntityTypeSearchResults::class);
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setTotalCount(100);


        $this->commandGetListMock->expects($this->once())
            ->method('execute')
            ->with($searchCriteria)
            ->willReturn($searchResult);

        $result = $this->repository->getList($searchCriteria);

        $this->assertInstanceOf(EntityTypeSearchResultsInterface::class, $result);
        $this->assertEquals($searchResult->getTotalCount(), $result->getTotalCount());
    }
}
