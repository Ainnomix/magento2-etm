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

use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType\Delete;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{

    /**
     * @var MockObject|EntityTypeRepositoryInterface
     */
    private $repositoryMock;

    /**
     * @var MockObject|RequestInterface
     */
    private $requestMock;

    /**
     * @var MockObject|ManagerInterface
     */
    private $messageManagerMock;

    /**
     * @var MockObject|RedirectFactory
     */
    private $redirectFactoryMock;

    /**
     * @var Delete
     */
    private $action;

    protected function setUp(): void
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

        $this->repositoryMock = $this->getMockBuilder(EntityTypeRepositoryInterface::class)
            ->setMethods(['deleteById'])
            ->getMockForAbstractClass();

        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
            ->setMethods(['getParam'])
            ->getMockForAbstractClass();

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
            ->method('getMessageManager')
            ->willReturn($this->messageManagerMock);
        $contextMock->expects($this->once())
            ->method('getResultRedirectFactory')
            ->willReturn($this->redirectFactoryMock);

        $this->action = new Delete($contextMock, $this->repositoryMock);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testExecute(int $entityTypeId, ?Exception  $exception): void
    {
        $this->requestMock->expects($this->once())
            ->method('getParam')
            ->with('id')
            ->willReturn($entityTypeId);

        $invocationMocker = $this->repositoryMock->expects($this->once())
            ->method('deleteById')
            ->with($entityTypeId);

        if ($exception) {
            $invocationMocker->willThrowException($exception);
            $this->messageManagerMock->expects($this->once())
                ->method('addErrorMessage')
                ->with($exception->getMessage());
        }

        $redirectMock = $this->getMockBuilder(Redirect::class)
            ->disableOriginalConstructor()
            ->setMethods(['setPath'])
            ->getMock();

        $this->redirectFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($redirectMock);

        $result = $this->action->execute();

        $this->assertInstanceOf(Redirect::class, $result);
        $this->assertEquals($redirectMock, $result);
    }

    public function dataProvider(): array
    {
        return [
            'Success' => [
                10,
                null
            ],
            'NoSuchEntityException' => [
                20,
                new NoSuchEntityException(__('Requested entity type does not exist.'))
            ],
            'CouldNotDeleteException' => [
                30,
                new CouldNotDeleteException(__('Could not delete entity type does not exist.'))
            ],
            'Exception' => [
                40,
                new Exception('Test exception')
            ]
        ];
    }
}
