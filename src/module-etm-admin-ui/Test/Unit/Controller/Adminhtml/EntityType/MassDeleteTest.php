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

use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType\MassDelete;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType\Collection;
use Ainnomix\EtmCore\Model\ResourceModel\EntityType\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use function count;

class MassDeleteTest extends TestCase
{

    /**
     * @var MockObject|ManagerInterface
     */
    private $messageManagerMock;

    /**
     * @var MockObject|RedirectFactory
     */
    private $redirectFactoryMock;

    /**
     * @var MockObject|CollectionFactory
     */
    private $factoryMock;

    /**
     * @var MockObject|Filter
     */
    private $filterMock;

    /**
     * @var MockObject|EntityTypeRepositoryInterface
     */
    private $repositoryMock;

    /**
     * @var MassDelete
     */
    private $action;

    protected function setUp(): void
    {
        $contextMock = $this->getMockBuilder(Context::class)
            ->setMethods(
                [
                    'getAuth',
                    'getHelper',
                    'getBackendUrl',
                    'getCanUseBaseUrl',
                    'getAuthorization',
                    'getFormKeyValidator',
                    'getLocaleResolver',
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

        $this->messageManagerMock = $this->getMockBuilder(ManagerInterface::class)
            ->setMethods(['addSuccessMessage', 'addErrorMessage'])
            ->getMockForAbstractClass();
        $this->redirectFactoryMock = $this->getMockBuilder(RedirectFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $contextMock->expects($this->once())
            ->method('getMessageManager')
            ->willReturn($this->messageManagerMock);
        $contextMock->expects($this->once())
            ->method('getResultRedirectFactory')
            ->willReturn($this->redirectFactoryMock);

        $this->factoryMock = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->filterMock = $this->getMockBuilder(Filter::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCollection'])
            ->getMock();
        $this->repositoryMock = $this->getMockBuilder(EntityTypeRepositoryInterface::class)
            ->setMethods(['deleteById'])
            ->getMockForAbstractClass();

        $this->action = new MassDelete(
            $contextMock,
            $this->filterMock,
            $this->factoryMock,
            $this->repositoryMock
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testExecute(bool $withException): void
    {
        $typeIds = [10, 20, 30];

        $collectionMock = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAllIds'])
            ->getMock();

        $this->factoryMock->expects($this->once())
            ->method('create')
            ->willReturn($collectionMock);
        $this->filterMock->expects($this->once())
            ->method('getCollection')
            ->with($collectionMock)
            ->willReturn($collectionMock);
        $collectionMock->expects($this->once())
            ->method('getAllIds')
            ->willReturn($typeIds);

        if (!$withException) {
            foreach ($typeIds as $index => $value) {
                $this->repositoryMock->expects($this->at($index))
                    ->method('deleteById')
                    ->with($value);
            }

            $this->messageManagerMock->expects($this->once())
                ->method('addSuccessMessage')
                ->with(__('A total of %1 record(s) were deleted.', count($typeIds)));
        }

        if ($withException) {
            $exception = new CouldNotDeleteException(__('Test exception'));
            $this->repositoryMock->expects($this->once())
                ->method('deleteById')
                ->with(10)
                ->willThrowException($exception);

            $this->messageManagerMock->expects($this->once())
                ->method('addErrorMessage')
                ->with('Test exception');
        }

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

        $result = $this->action->execute();
        $this->assertInstanceOf(Redirect::class, $result);
    }

    public function dataProvider(): array
    {
        return [[true], [false]];
    }
}
