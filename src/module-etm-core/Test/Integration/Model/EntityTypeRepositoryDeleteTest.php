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
 * Test class for "deleteById" action of EntityTypeRepository
 *
 * @magentoDbIsolation enabled
 */
class EntityTypeRepositoryDeleteTest extends EntityTypeRepositoryTest
{

    /**
     * @param int|null    $entityTypeId
     * @param bool        $createEntityType
     * @param string|null $exceptionClass
     * @param string|null $exceptionMessage
     *
     * @dataProvider providerEntityTypeDelete
     */
    public function testEntityTypeDelete(
        ?int $entityTypeId,
        bool $createEntityType,
        ?string $exceptionClass,
        ?string $exceptionMessage
    ): void {
        if (true === $createEntityType) {
            $entityTypeId = $this->createEntityType('entity_type_300', 'entity_type_300');
        }

        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
        }
        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        $this->entityTypeRepository->deleteById($entityTypeId);
    }

    public function providerEntityTypeDelete(): array
    {
        return [
            'Delete entity type'             => [null, true, null, null],
            'Delete nonexistent entity type' => [1000, false, NoSuchEntityException::class, null],
            'Delete system entity type'      => [4, false, NoSuchEntityException::class, null]
        ];
    }
}
