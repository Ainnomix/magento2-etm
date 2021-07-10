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

use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType\NewAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NewActionTest extends TestCase
{

    /**
     * @var MockObject|ResultFactory
     */
    private $resultFactoryMock;

    /**
     * @var NewAction
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
                    'getCanUseBaseUrl',
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

        $this->resultFactoryMock = $this->getMockBuilder(ResultFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $contextMock->expects($this->once())
            ->method('getResultFactory')
            ->willReturn($this->resultFactoryMock);

        $this->action = new NewAction($contextMock);
    }

    public function testExecute(): void
    {
        $forwardMock = $this->getMockBuilder(Forward::class)
            ->setMethods(['forward'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultFactoryMock->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_FORWARD)
            ->willReturn($forwardMock);
        $forwardMock->expects($this->once())
            ->method('forward')
            ->with('edit')
            ->willReturnSelf();

        $result = $this->action->execute();
        $this->assertInstanceOf(Forward::class, $result);
    }
}
