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

use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmCore\Model\Data\EntityTypeSearchResults;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * Class EntityTypeRepositoryTest
 *
 * @magentoDbIsolation enabled
 * @magentoDataFixture entityTypeFixture
 */
class EntityTypeRepositoryTest extends TestCase
{

    use EntityTypeHelperTrait;

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    protected function setUp()
    {
        $this->entityTypeRepository = Bootstrap::getObjectManager()->get(EntityTypeRepositoryInterface::class);
    }

    /**
     * @param array $entityTypeCodes
     * @param int   $collectionSize
     *
     * @dataProvider providerGetList
     */
    public function testGetList(array $entityTypeCodes, int $collectionSize): void
    {
        /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
        $searchCriteriaBuilder = Bootstrap::getObjectManager()->get(SearchCriteriaBuilder::class);
        $searchCriteriaBuilder->addFilter('entity_type_code', $entityTypeCodes, 'in');
        $searchCriteria = $searchCriteriaBuilder->create();

        $searchResult = $this->entityTypeRepository->getList($searchCriteria);

        $this->assertInstanceOf(EntityTypeSearchResults::class, $searchResult);
        $this->assertEquals($collectionSize, $searchResult->getTotalCount());

        $entityType = self::getEntityType();

        $contain = false;
        foreach ($searchResult->getItems() as $item) {
            if ((int) $item->getEntityTypeId() === (int) $entityType->getEntityTypeId()) {
                $contain = true;
                break;
            }
        }

        $this->assertTrue($contain);
    }

    public function providerGetList(): array
    {
        return [
            'Custom entity types' => [['entity_type_test'], 1],
            'Mixed entity types'  => [['entity_type_test', 'catalog_product'], 1]
        ];
    }

    /**
     * @param int|null    $entityTypeId
     * @param string      $entityTypeCode
     * @param string|null $exceptionClass
     * @param string|null $exceptionMessage
     *
     * @dataProvider providerGetById
     */
    public function testGetById(
        ?int $entityTypeId,
        string $entityTypeCode,
        ?string $exceptionClass,
        ?string $exceptionMessage
    ): void {
        if (null === $entityTypeId) {
            $entityTypeId = (int) $this->getEntityType()->getEntityTypeId();
        }

        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
        }
        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        $entityType = $this->entityTypeRepository->getById($entityTypeId);

        $this->assertEquals($entityTypeCode, $entityType->getEntityTypeCode());
        $this->assertEquals($entityTypeId, $entityType->getEntityTypeId());
    }

    public function providerGetById(): array
    {
        return [
            'Load entity type' => [
                null,
                'entity_type_test',
                null,
                null,
            ],
            'Load nonexistent entity type' => [
                101,
                'entity_type_201',
                NoSuchEntityException::class,
                null,
            ],
            'Load system entity type' => [
                4,
                'catalog_product',
                NoSuchEntityException::class,
                null,
            ],
        ];
    }

    /**
     * @param string      $entityTypeCode
     * @param string|null $exceptionClass
     * @param string|null $exceptionMessage
     *
     * @dataProvider providerGet
     */
    public function testGet(
        string $entityTypeCode,
        ?string $exceptionClass,
        ?string $exceptionMessage
    ): void {
        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
        }
        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        $entityType = $this->entityTypeRepository->get($entityTypeCode);

        $this->assertEquals($entityTypeCode, $entityType->getEntityTypeCode());
    }

    public function providerGet(): array
    {
        return [
            'Load entity type' => [
                'entity_type_test',
                null,
                null
            ],
            'Load nonexistent entity type' => [
                'entity_type_101',
                NoSuchEntityException::class,
                null
            ],
            'Load system entity type' => [
                'catalog_product',
                NoSuchEntityException::class,
                null
            ],
        ];
    }

    /**
     * @param int|null    $entityTypeId
     * @param string|null $exceptionClass
     * @param string|null $exceptionMessage
     *
     * @dataProvider providerDeleteById
     */
    public function testDeleteById(
        ?int $entityTypeId,
        ?string $exceptionClass,
        ?string $exceptionMessage
    ): void {
        if (null === $entityTypeId) {
            $entityTypeId = $this->getEntityType()->getEntityTypeId();
        }

        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
        }
        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        $this->entityTypeRepository->deleteById($entityTypeId);
    }

    public function providerDeleteById(): array
    {
        return [
            'Delete entity type'             => [null, null, null],
            'Delete nonexistent entity type' => [1000, NoSuchEntityException::class, null],
            'Delete system entity type'      => [4, NoSuchEntityException::class, null]
        ];
    }

    /**
     * Entity creation tests
     *
     * @param string      $entityTypeCode
     * @param string|null $entityTypeName
     * @param string|null $exceptionClass
     * @param string|null $exceptionMessage
     *
     * @dataProvider providerSave
     */
    public function testEntityTypeSave(
        string $entityTypeCode,
        ?string $entityTypeName,
        ?string $exceptionClass,
        ?string $exceptionMessage
    ): void {
        /** @var EntityTypeInterfaceFactory $entityTypeFactory */
        $entityTypeFactory = Bootstrap::getObjectManager()->get(EntityTypeInterfaceFactory::class);

        $entityType = $entityTypeFactory->create();
        $entityType->setEntityTypeCode($entityTypeCode);

        if (null !== $entityTypeName) {
            $entityType->setEntityTypeName($entityTypeName);
        }

        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
        }
        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        $savedEntityTypeId = $this->entityTypeRepository->save($entityType);
        if (null === $exceptionClass && null === $exceptionMessage) {
            $this->assertNotEmpty($savedEntityTypeId, 'Failed to save entity type. Empty entity type ID');
        }
    }

    public function providerSave(): array
    {
        return [
            'Valid entity type data'    => ['entity_1', 'Entity Type 1', null, null],
            'Invalid entity type name'  => ['entity_2', null, CouldNotSaveException::class, null],
            'Invalid entity type code'  => ['entity 3', 'Entity Type 3', CouldNotSaveException::class, null],
            'Existing entity type code' => ['entity_type_test', 'entity_type_test', CouldNotSaveException::class, null]
        ];
    }

    public static function entityTypeFixture(): void
    {
        self::getEntityType();
    }
}
