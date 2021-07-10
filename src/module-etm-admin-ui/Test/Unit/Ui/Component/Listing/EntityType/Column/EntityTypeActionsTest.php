<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Test\Unit\Ui\Component\Listing\EntityType\Column;

use Ainnomix\EtmAdminUi\Ui\Component\Listing\EntityType\Column\EntityTypeActions;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\UrlInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EntityTypeActionsTest extends TestCase
{

    /**
     * @var MockObject|UrlInterface
     */
    private $urlBuilderMock;

    /**
     * @var EntityTypeActions
     */
    private $entityTypeActions;

    protected function setUp()
    {
        $this->urlBuilderMock = $this->getMockBuilder(UrlInterface::class)
            ->setMethods(['getUrl'])
            ->getMockForAbstractClass();

        $objectManager = new ObjectManager($this);
        $this->entityTypeActions = $objectManager->getObject(
            EntityTypeActions::class,
            [
                'urlBuilder' => $this->urlBuilderMock,
                'data' => [
                    'name' => 'test_type_actions'
                ]
            ]
        );
    }

    public function testPrepareDataSource()
    {
        $expectedData = [
            'data' => [
                'items' => [
                    [
                        'entity_type_id' => 10,
                        'entity_type_code' => 'test_entity',
                        'test_type_actions' => [
                            'edit' => [
                                'href' => 'etm/entityType/edit/id/10',
                                'label' => __('Edit'),
                                'hidden' => false
                            ],
                            'delete' => [
                                'href' => 'etm/entityType/delete/id/10',
                                'label' => __('Delete'),
                                'hidden' => false,
                                'confirm' => [
                                    'title' => __('Delete %1', 'test_entity'),
                                    'message' => __('Are you sure you want to delete a %1 record?', 'test_entity')
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->urlBuilderMock->expects($this->at(0))
            ->method('getUrl')
            ->with('etm/entityType/edit', ['id' => 10])
            ->willReturn('etm/entityType/edit/id/10');
        $this->urlBuilderMock->expects($this->at(1))
            ->method('getUrl')
            ->with('etm/entityType/delete', ['id' => 10])
            ->willReturn('etm/entityType/delete/id/10');

        $this->assertEquals($expectedData, $this->entityTypeActions->prepareDataSource($expectedData));
    }
}
