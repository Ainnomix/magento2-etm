<?php
/**
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

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * Class EntityTypeRepositoryTest
 */
abstract class EntityTypeRepositoryTest extends TestCase
{

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    /**
     * @var EntityTypeInterfaceFactory
     */
    protected $entityTypeFactory;

    protected function setUp()
    {
        $this->entityTypeRepository = Bootstrap::getObjectManager()->create(EntityTypeRepositoryInterface::class);
        $this->entityTypeFactory = Bootstrap::getObjectManager()->create(EntityTypeInterfaceFactory::class);
    }

    protected function createEntityType(string $entityTypeCode, string $entityTypeName): int
    {
        $entityType = $this->entityTypeFactory->create();
        $entityType->setEntityTypeCode($entityTypeCode);
        $entityType->setEntityTypeName($entityTypeName);

        return $this->entityTypeRepository->save($entityType);
    }
}
