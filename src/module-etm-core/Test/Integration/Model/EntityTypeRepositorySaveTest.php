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

/**
 * Test class for "save" action of EntityTypeRepository
 *
 * @magentoDbIsolation enabled
 */
class EntityTypeRepositorySaveTest extends EntityTypeRepositoryTest
{

    /**
     * Entity creation tests
     *
     * @param int|null    $entityTypeId
     * @param string      $entityTypeCode
     * @param string|null $entityTypeName
     * @param string|null $exceptionClass
     * @param string|null $exceptionMessage
     *
     * @dataProvider providerSaveEntityType
     */
    public function testEntityTypeSave(
        ?int $entityTypeId,
        string $entityTypeCode,
        ?string $entityTypeName,
        ?string $exceptionClass,
        ?string $exceptionMessage
    ): void {
        $entityType = $this->entityTypeFactory->create();
        $entityType->setEntityTypeCode($entityTypeCode);

        if (null !== $entityTypeId) {
            $entityType->setEntityTypeId($entityTypeId);
        }
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

    public function providerSaveEntityType(): array
    {
        return [
            'Valid entity type data' => [null, 'entity_1', 'Entity Type 1', null, null],
            'Invalid entity type name' => [null, 'entity_2', null, CouldNotSaveException::class, null],
            'Invalid entity type code' => [null, 'entity 3', 'Entity Type 3', CouldNotSaveException::class, null],
            'Existing entity type code' => [null, 'entity_1', 'Entity Type 1', CouldNotSaveException::class, null]
        ];
    }
}
