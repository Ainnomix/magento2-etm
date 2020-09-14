<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Test\Unit\Helper\Entity;

use Ainnomix\EtmAdminUi\Helper\Entity\Attribute;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{

    private $attributeHelper;

    protected function setUp(): void
    {
        $this->attributeHelper = new Attribute();
    }

    /**
     * @dataProvider attributeSourceModelProvider
     */
    public function testGetAttributeSourceModelByInputType(string $inputType, ?string $expectedResult): void
    {
        $result = $this->attributeHelper->getAttributeSourceModelByInputType($inputType);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider attributeBackendModelProvider
     */
    public function testGetAttributeBackendModelByInputType(string $inputType, ?string $expectedResult): void
    {
        $result = $this->attributeHelper->getAttributeBackendModelByInputType($inputType);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider attributeInputTypesProvider
     */
    public function testGetAttributeInputTypes(?string $inputType, array $expectedResult): void
    {
        $result = $this->attributeHelper->getAttributeInputTypes($inputType);
        $this->assertEquals($expectedResult, $result);
    }

    public function attributeSourceModelProvider(): array
    {
        return [
            ['multiselect', null],
            ['boolean', Boolean::class],
            ['test', null]
        ];
    }

    public function attributeBackendModelProvider(): array
    {
        return [
            ['multiselect', ArrayBackend::class],
            ['boolean', null],
            ['test', null]
        ];
    }

    public function attributeInputTypesProvider(): array
    {
        return [
            [
                'multiselect',
                [
                    'backend_model' => ArrayBackend::class
                ]
            ],
            [
                null,
                [
                    'multiselect' => ['backend_model' => ArrayBackend::class],
                    'boolean' => ['source_model' => Boolean::class],
                ]
            ],
            [
                'test',
                []
            ]
        ];
    }
}
