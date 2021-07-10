<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Test\Unit\Model;

use Ainnomix\EtmCore\Model\EntityType;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;

class EntityTypeTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var EntityType
     */
    protected $model;

    /**
     * @var ObjectManagerHelper
     */
    protected $objectManagerHelper;

    protected function setUp(): void
    {
        $contextMock = $this->createPartialMock(
            \Magento\Framework\Model\Context::class,
            []
        );

        $this->objectManagerHelper = new ObjectManagerHelper($this);

        $this->model = $this->objectManagerHelper->getObject(
            EntityType::class,
            [
                'context' => $contextMock
            ]
        );
    }

    public function testGetEntityTypeId(): void
    {
        $expectedId = 10;

        $entityTypeId = $this->model->getEntityTypeId();

        $this->assertNull($entityTypeId);

        $this->model->setData('entity_type_id', $expectedId);
        $entityTypeId = $this->model->getEntityTypeId();

        $this->assertTrue(is_int($entityTypeId));
        $this->assertEquals($expectedId, $entityTypeId);
    }

    public function testSetEntityTypeId(): void
    {
        $expectedId = 10;

        $this->model->setEntityTypeId($expectedId);
        $entityTypeId = $this->model->getEntityTypeId();

        $this->assertTrue($this->model->hasDataChanges());
        $this->assertTrue(is_int($entityTypeId));
        $this->assertEquals($expectedId, $entityTypeId);
    }

    public function testGetEntityTypeName(): void
    {
        $expected = 'Custom Entity Type';

        $this->model->setEntityTypeName($expected);
        $entityTypeName = $this->model->getEntityTypeName();

        $this->assertEquals($expected, $entityTypeName);
    }

    public function testSetEntityTypeName(): void
    {
        $expected = 'Custom Entity Type';

        $this->model->setEntityTypeName($expected);
        $entityTypeName = $this->model->getEntityTypeName();

        $this->assertTrue($this->model->hasDataChanges());
        $this->assertEquals($expected, $entityTypeName);
    }

    public function testGetEntityTypeCode(): void
    {
        $expectedCode = 'test_code';

        $entityTypeCode = $this->model->getEntityTypeCode();

        $this->assertNull($entityTypeCode);

        $this->model->setData('entity_type_code', $expectedCode);
        $entityTypeCode = $this->model->getEntityTypeCode();

        $this->assertTrue(is_string($entityTypeCode));
        $this->assertEquals($expectedCode, $entityTypeCode);
    }

    public function testSetEntityTypeCode(): void
    {
        $expectedCode = 'test_code';

        $this->model->setEntityTypeCode($expectedCode);
        $entityTypeCode = $this->model->getEntityTypeCode();

        $this->assertTrue($this->model->hasDataChanges());
        $this->assertTrue(is_string($entityTypeCode));
        $this->assertEquals($expectedCode, $entityTypeCode);
    }

    public function testGetDefaultAttributeSetId(): void
    {
        $expectedId = 100;

        $this->model->setDefaultAttributeSetId($expectedId);
        $attributeSetId = $this->model->getDefaultAttributeSetId();

        $this->assertTrue(is_int($attributeSetId));
        $this->assertEquals($expectedId, $attributeSetId);
    }

    public function testSetDefaultAttributeSetId(): void
    {
        $expectedId = 100;

        $this->model->setDefaultAttributeSetId($expectedId);
        $attributeSetId = $this->model->getDefaultAttributeSetId();

        $this->assertTrue($this->model->hasDataChanges());
        $this->assertTrue(is_int($attributeSetId));
        $this->assertEquals($expectedId, $attributeSetId);
    }

    public function testIsCustom(): void
    {
        $this->model->setData('is_custom', true);
        $this->assertTrue($this->model->isCustom());

        $this->assertTrue($this->model->isCustom(false));
        $this->assertFalse($this->model->isCustom());
    }
}
