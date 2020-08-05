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

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Test class for "getById" action of EntityTypeRepository
 *
 * @magentoDbIsolation enabled
 */
class EntityTypeRepositoryGetByIdTest extends EntityTypeRepositoryTest
{

    /**
     * @param int|null    $entityTypeId
     * @param string      $entityTypeCode
     * @param bool        $createEntityType
     * @param string|null $exceptionClass
     * @param string|null $exceptionMessage
     *
     * @throws NoSuchEntityException
     *
     * @dataProvider providerGetEntityType
     */
    public function testEntityTypeGetById(
        ?int $entityTypeId,
        string $entityTypeCode,
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

        $entityType = $this->entityTypeRepository->getById($entityTypeId);

        $this->assertEquals($entityTypeCode, $entityType->getEntityTypeCode());
        $this->assertEquals($entityTypeId, $entityType->getEntityTypeId());
    }

    public function providerGetEntityType(): array
    {
        return [
            'Load entity type' => [
                null,
                'entity_type_200',
                true,
                null,
                null
            ],
            'Load nonexistent entity type' => [
                101,
                'entity_type_201',
                false,
                NoSuchEntityException::class,
                null
            ],
            'Load system entity type' => [
                4,
                'catalog_product',
                false,
                NoSuchEntityException::class,
                null
            ],
        ];
    }
}
