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

namespace Ainnomix\EtmAdminUi\Test\Unit\Controller\Adminhtml\EntityType;

use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType\Edit;
use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType\Initialization\Helper;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterfaceFactory;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Result\Page;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EditTest extends TestCase
{

    private $requestMock;

    private $resultFactoryMock;

    private $messageManagerMock;

    private $redirectFactoryMock;

    private $repositoryMock;

    private $typeFactoryMock;

    private $action;

    protected function setUp():void
    {
        $contextMock = $this->getMockBuilder(Context::class)
            ->setMethods(
                [
                    'getAuthorization',
                    'getAuth',
                    'getHelper',
                    'getBackendUrl',
                    'getFormKeyValidator',
                    'getLocaleResolver',
                    'getCanUseBaseUrl',
                    'getSession',
                    'getObjectManager',
                    'getEventManager',
                    'getUrl',
                    'getActionFlag',
                    'getRedirect',
                    'getView',
                    'getMessageManager',
                    'getRequest',
                    'getResponse',
                    'getResultRedirectFactory',
                    'getResultFactory'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
            ->setMethods(['getParam'])
            ->getMockForAbstractClass();
        $this->resultFactoryMock = $this->getMockBuilder(ResultFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->messageManagerMock = $this->getMockBuilder(ManagerInterface::class)
            ->setMethods(['addSuccessMessage', 'addErrorMessage'])
            ->getMockForAbstractClass();
        $this->redirectFactoryMock = $this->getMockBuilder(RedirectFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $contextMock->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestMock);
        $contextMock->expects($this->once())
            ->method('getResultFactory')
            ->willReturn($this->resultFactoryMock);
        $contextMock->expects($this->once())
            ->method('getMessageManager')
            ->willReturn($this->messageManagerMock);
        $contextMock->expects($this->once())
            ->method('getResultRedirectFactory')
            ->willReturn($this->redirectFactoryMock);

        $this->repositoryMock = $this->getMockBuilder(EntityTypeRepositoryInterface::class)
            ->setMethods(['getById'])
            ->getMockForAbstractClass();
        $this->typeFactoryMock = $this->getMockBuilder(EntityTypeInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $helper = new Helper($this->repositoryMock, $this->typeFactoryMock);
        $this->action = new Edit($contextMock, $helper);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testExecute(int $entityTypeId, ?Exception $exception): void
    {
        $this->requestMock->expects($this->once())
            ->method('getParam')
            ->with('id')
            ->willReturn($entityTypeId);

        $pageMock = $this->getMockBuilder(Page::class)
            ->disableOriginalConstructor()
            ->setMethods(['setActiveMenu', 'getConfig'])
            ->getMock();

        $this->resultFactoryMock->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_PAGE)
            ->willReturn($pageMock);

        $entityTypeMock = $this->getMockBuilder(EntityTypeInterface::class)
            ->setMethods(['getEntityTypeId', 'getEntityTypeCode'])
            ->getMockForAbstractClass();

        if ($entityTypeId) {
            $invocationMocker = $this->repositoryMock->expects($this->once())
                ->method('getById')
                ->with($entityTypeId);
            if (!$exception) {
                $invocationMocker->willReturn($entityTypeMock);
            }
            if ($exception) {
                $invocationMocker->willThrowException($exception);
            }
        }

        if (!$exception) {
            $expectedResult = $this->callWithoutException($entityTypeId, $pageMock, $entityTypeMock);
        }
        if ($exception) {
            $expectedResult = $this->callWithException($exception);
        }

        $result = $this->action->execute();
        $this->assertEquals($expectedResult, $result);

        $exception === null ? $this->assertInstanceOf(Page::class, $result)
            : $this->assertInstanceOf(Redirect::class, $result);
    }

    public function dataProvider(): array
    {
        return [
            [10, null],
            [0, null],
            [20, new NoSuchEntityException(__('Requested entity type does not exist.'))],
            [30, new Exception('Test exception')]
        ];
    }

    private function callWithoutException(
        int $entityTypeId,
        MockObject $pageMock,
        MockObject $entityTypeMock
    ): MockObject {
        if (!$entityTypeId) {
            $this->typeFactoryMock->expects($this->once())
                ->method('create')
                ->willReturn($entityTypeMock);
        }

        $pageMock->expects($this->once())
            ->method('setActiveMenu')
            ->with('Ainnomix_EtmAdminhtml::management_index');

        $configMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTitle'])
            ->getMock();
        $titleMock = $this->getMockBuilder(Title::class)
            ->disableOriginalConstructor()
            ->setMethods(['prepend'])
            ->getMock();

        $pageMock->expects($this->exactly(2))
            ->method('getConfig')
            ->willReturn($configMock);
        $configMock->expects($this->exactly(2))
            ->method('getTitle')
            ->willReturn($titleMock);
        $titleMock->expects($this->at(0))
            ->method('prepend')
            ->with(__('Entity Type Manager'));

        $entityTypeMock->expects($this->once())
            ->method('getEntityTypeId')
            ->willReturn($entityTypeId);

        if ($entityTypeId) {
            $entityTypeCode = 'test_entity_type';

            $entityTypeMock->expects($this->once())
                ->method('getEntityTypeCode')
                ->willReturn($entityTypeCode);
            $titleMock->expects($this->at(1))
                ->method('prepend')
                ->with(__('Edit "%1" type', $entityTypeCode));
        }

        if (!$entityTypeId) {
            $titleMock->expects($this->at(1))
                ->method('prepend')
                ->with(__('Create Entity Type'));
        }

        return $pageMock;
    }

    private function callWithException(Exception $exception): MockObject
    {
        $this->messageManagerMock->expects($this->once())
            ->method('addErrorMessage')
            ->with($exception->getMessage());

        $redirectMock = $this->getMockBuilder(Redirect::class)
            ->disableOriginalConstructor()
            ->setMethods(['setPath'])
            ->getMock();
        $this->redirectFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($redirectMock);
        $redirectMock->expects($this->once())
            ->method('setPath')
            ->with('*/*/');

        return $redirectMock;
    }
}
