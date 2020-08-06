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

namespace Ainnomix\EtmCore\Test\Integration\Model\Entity;

use Ainnomix\EtmCore\Test\Integration\Model\EntityTypeHelperTrait;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 * @magentoDataFixture attributeFixture
 */
class AttributeRepositoryTest extends TestCase
{

    use EntityTypeHelperTrait;

    public function testGetList(): void
    {

    }

    public function testGet(): void
    {

    }

    public function testDeleteById(): void
    {

    }

    public function testSave(): void
    {

    }

    public static function attributeFixture(): void
    {
        $entityType = self::getEntityType();
        self::getAttributeSet($entityType);
    }
}
