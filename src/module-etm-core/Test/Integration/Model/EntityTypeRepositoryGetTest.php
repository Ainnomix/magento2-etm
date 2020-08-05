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

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Test class for "get" action of EntityTypeRepository
 *
 * @magentoDbIsolation enabled
 */
class EntityTypeRepositoryGetTest extends EntityTypeRepositoryTest
{

    private $entityTypeId;

    protected function setUp()
    {
        parent::setUp();

        $entityType = $this->entityTypeFactory->create();
        $entityType->setEntityTypeCode('entity_type_10');
        $entityType->setEntityTypeName('entity_type_10');

        $this->entityTypeId = $this->entityTypeRepository->save($entityType);
    }

    /**
     * @param string      $entityTypeCode
     * @param int|null    $entityTypeId
     * @param bool        $createEntityType
     * @param string|null $exceptionClass
     * @param string|null $exceptionMessage
     *
     * @throws NoSuchEntityException
     *
     * @dataProvider providerGetEntityType
     */
    public function testEntityTypeGet(
        string $entityTypeCode,
        ?int $entityTypeId,
        bool $createEntityType,
        ?string $exceptionClass,
        ?string $exceptionMessage
    ): void {
        if (true === $createEntityType) {
            $entityTypeId = $this->createEntityType($entityTypeCode, $entityTypeCode);
        }

        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
        }
        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        $entityType = $this->entityTypeRepository->get($entityTypeCode);

        $this->assertEquals($entityTypeCode, $entityType->getEntityTypeCode());
        $this->assertEquals($entityTypeId, $entityType->getEntityTypeId());
    }

    public function providerGetEntityType(): array
    {
        return [
            'Load entity type' => [
                'entity_type_100',
                null,
                true,
                null,
                null
            ],
            'Load nonexistent entity type' => [
                'entity_type_101',
                null,
                false,
                NoSuchEntityException::class,
                null
            ],
            'Load system entity type' => [
                'catalog_product',
                4,
                false,
                NoSuchEntityException::class,
                null
            ],
        ];
    }
}
